<?php
class UserController {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function getUserLogin($identifier) {
        if (is_string($identifier)) {
            $username = $identifier;
            
            $sql = 'SELECT * FROM users WHERE username = ?';

            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param('s', $username);
            $stmt->execute();
    
            $result = $stmt->get_result();
            $user = $result->fetch_assoc();
            
            return $user;
        } else if (is_numeric($identifier)) {
            $id = $identifier;
            
            $sql = 'SELECT * FROM users WHERE id = ?';

            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param('i', $id);
            $stmt->execute();
    
            $result = $stmt->get_result();
            $user = $result->fetch_assoc();
            
            return $user;
        }
    }

    public function createUser($username, $password) {
        $password_hash = password_hash($password, PASSWORD_ARGON2ID);
    
        $sql = 'INSERT INTO users(username, password_hash) VALUES (?, ?)';
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('ss', $username, $password_hash);
        if ($stmt->execute()) {
            return;
        } else {
            if ($stmt->errno === 1062) {
                die (redirectWithError('/signup', 'Username already exists'));
            } else {
                die (redirectWithError('/signup', 'Error: ' . $stmt->error . '<br>Error Code: ' . $stmt->errno));
            }
        }
    }
    
    public function createAuthCookie($user_id) {
        $token = bin2hex(random_bytes(16));
    
        $expire = 3600 * 24 * 30;
    
        $expire_date = new DateTime();
        $expire_date->modify('+' . $expire . ' seconds');
        $expire_date_str = $expire_date->format('Y-m-d H:i:s');
    
        setcookie('auth_token', $token, time() + $expire, '/', '', true, true);
    
        $sql = 'INSERT INTO user_tokens (user_id, token, expires_at) VALUES (?, ?, ?)';
    
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('iss', $user_id, $token, $expire_date_str);
    
        if (!$stmt->execute()) {
            throw new Exception('Error creating auth token: ' . $stmt->error);
        }
    }

    public function getUsername($user_id) {
        $sql = 'SELECT username FROM users WHERE id = ?';

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('s', $user_id);
        
        if ($stmt->execute()) {
            $results = $stmt->get_result();

            if ($results->num_rows > 0) {
                $row = $results->fetch_assoc();
                $username = $row['username'];
                return $username;
            }
        } else {
            die ('User ID invalid');
        }
    }

    public function checkToken($token) {
        $sql = 'SELECT user_id FROM user_tokens WHERE token = ?';

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('s', $token);
        
        if ($stmt->execute()) {
            $results = $stmt->get_result();

            if ($results->num_rows > 0) {
                $row = $results->fetch_assoc();
                $user_id = $row['user_id'];
                return $user_id;
            }
        } else {
            die ('Token invalid');
        }
    }
}