<?php
function cleanDB($conn) {
    deleteExpiredTokens($conn);
}

function checkAuthCookie($userController) {
    if (isset($_COOKIE['auth_token'])) {
        $_SESSION['user_id'] = $userController->checkToken($_COOKIE['auth_token']);
    }
}

function setUsername($userController) {
    if (isset($_SESSION['user_id'])) {
        $_SESSION['username'] = $userController->getUsername($_SESSION['user_id']);
    }
}

function getAuthTokens($conn) {
    $tokens = [];

    $sql = 'SELECT * FROM user_tokens';
    $stmt = $conn->prepare($sql);

    if (!$stmt->execute()) {
        throw new Exception($stmt->error);
    }

    $results = $stmt->get_result();
    if ($results->num_rows > 0) {
        while ($row = $results->fetch_assoc()) {
            $tokens[] = $row;
        }
    }

    return $tokens;
}

function deleteExpiredTokens($conn) {
    $tokens = getAuthTokens($conn);

    foreach ($tokens as $token) {
        $id = $token['id'];
        $expires_at = $token['expires_at'];

        $now = new DateTime();
        $expires_at_date = new DateTime($expires_at);

        if ($expires_at_date < $now) {
            deleteToken($conn, $id);
        }
    }
}

function deleteToken($conn, $id) {
    $sql = 'DELETE FROM user_tokens WHERE id = ?';
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $id);
    $stmt->execute();
}