<?php
function note_routes($router, $userController, $noteController) {
    $router->get('/create', function () use ($router) {
        global $stylesheets;
        global $scripts;
    
        if (isset($_SESSION['user_id'])) {
            echo $router->render_template('create.php', $stylesheets, $scripts);
        }  else {
            redirect('/login');
        }
    });

    $router->post('/save-note', function() use ($router, $noteController) {
        $data = json_decode(file_get_contents('php://input'), true);

        // Extract the title and content from the posted data
        $title = $data['title'];
        $content = $data['content'];
    
        // Save note to database
        $notesaved = $noteController->save($title, $content);
        
        // Return a response
        if ($notesaved) {
            echo json_encode(['success' => true, 'message' => 'Note uploaded successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to upload note']);
        }
    });
    
    $router->post('/modify-note', function() use ($noteController) {
        $data = json_decode(file_get_contents('php://input'), true);

        // Extract the title and content from the posted data
        $noteId = $data['noteId'];
        $title = $data['title'];
        $content = $data['content'];

        foreach ($data as $var) {
            logError($var);
        }

        logError($_SESSION['username']);
    
        // Save note to database
        $noteModified = $noteController->modifyNote($noteId, $title, $content);
        
        // Return a response
        if ($noteModified) {
            echo json_encode(['success' => true, 'message' => 'Note modified successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to modify note']);
        }
    });

    $router->post('/delete-note', function() use ($router, $noteController) {
        $data = json_decode(file_get_contents('php://input'), true);
    
        if (!isset($data['id']) || !is_int($data['id'])) {
            return json_encode(['success' => false, 'message' => 'Invalid or missing note ID']);
        }
    
        $noteId = $data['id'];
    
        try {
            $deleteSuccess = $noteController->deleteNote($noteId);
            if ($deleteSuccess) {
                return json_encode(['success' => true, 'message' => 'Note deleted successfully']);
            } else {
                return json_encode(['success' => false, 'message' => 'Deleting note failed']);
            }
        } catch (Exception $e) {
            return json_encode(['success' => false, 'message' => 'An error occurred: ' . $e->getMessage()]);
        }
    });

    $router->post('/clear-notes', function() use ($noteController) {
        $noteController->clearNotes();
    });
}