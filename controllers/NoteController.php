<?php
class NoteController {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function loadNotes() {
        $sql = "SELECT * FROM user_notes WHERE username = ?";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $_SESSION['username']);
        $stmt->execute();

        $result = $stmt->get_result();

        $notes = array();

        while ($row = $result->fetch_assoc()) {
            $notes[] = $row;
        }
        
        return $notes;
    }

    public function save($title, $note) {
        if (empty($title) || empty($note)) {
            return false;
        }

        $sql = 'INSERT INTO user_notes (username, title, note) VALUES (?, ?, ?)';

        if (!$stmt = $this->conn->prepare($sql)) {
            return false;
        }
        
        $stmt->bind_param("sss", $_SESSION['username'], $title, $note);

        if (!$stmt->execute()) {
            return false;
        }

        return true;
    }

    public function modifyNote($id, $title, $note) {
        $sql = 'UPDATE user_notes SET title = ?, note = ? WHERE id = ? AND username = ?';

        $stmt = $this->conn->prepare($sql);

        $stmt->bind_param('ssis', $title, $note, $id, $_SESSION['username']);
        
        // $stmt->bindParam(':title', $title);
        // $stmt->bindParam(':note', $note);
        // $stmt->bindParam(':noteId', $id);
        // $stmt->bindParam(':username', $_SESSION['username']);

        if (!$stmt->execute()) {
            return false;
        }

        return true;
    }

    public function deleteNote($id) {
        $sql = 'DELETE FROM user_notes WHERE id = ? AND username = ?';

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('is', $id, $_SESSION['username']);
        
        if (!$stmt->execute()) {
            return false;
        }

        return true;
    }

    public function clearnotes() {
        $sql = 'DELETE FROM user_notes WHERE username = ?';

        if (!$stmt = $this->conn->prepare($sql)) {
            return false;
        }

        $stmt->bind_param('s', $_SESSION['username']);

        if (!$stmt->execute()) {
            return false;
        }

        return true;
        
    }
}