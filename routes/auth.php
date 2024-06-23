<?php
function auth_routes($router, $userController) {
    $router->get('/login', function () use ($router) {
        global $stylesheets;
        global $paths;
        global $scripts;
        echo $router->render_template('login.php', $stylesheets, $paths, $scripts);
    });

    // Proccess login
    $router->post('/proccess-login', function() use ($userController) {
        if (empty($_POST['username'])) {
            die (redirectWithError('/login', 'Username required'));
        }
        if (empty($_POST['password'])) {
            die (redirectWithError('/login', 'Password required', $_POST['username']));
        }

        $username = $_POST['username'];
        $password = $_POST['password'];

        $user = $userController->getUserLogin($username);
        
        if ($user && password_verify($password, $user['password_hash'])) {
            echo 'Login successful!';
            
            if (isset($_POST['remember'])) {
                $userController->createAuthCookie($user['id']);
            } else {
                $_SESSION['user_id'] = $user['id'];
            }
            
            redirect('/');
        } else {
            die (redirectWithError('/login', 'Invalid username or password', $_POST['username']));
        }
    });

    $router->get('/signup', function () use ($router) {
        global $stylesheets;
        global $paths;
        global $scripts;
        echo $router->render_template('signup.php', $stylesheets, $paths, $scripts);
    });

    // Proccess sign up
    $router->post('/proccess-signup', function() use ($router, $userController) {
        if (empty($_POST['username'])) {
            die (redirectWithError('/signup', 'Username required'));
        }
        if (empty($_POST['password'])) {
            die (redirectWithError('/signup', 'Please enter a password', $_POST['username']));
        }
        if (strlen($_POST['password']) < 8) {
            die (redirectWithError('/signup', 'Passwords must be more than 8 characters long', $_POST['username']));
        }
        if (empty($_POST['confirm_password'])) {
            die (redirectWithError('/signup', 'Please confirm password', $_POST['username']));
        }
        if ($_POST['password'] != $_POST['confirm_password']) {
            die (redirectWithError('/signup', 'Passwords do not match', $_POST['username']));
        }

        $username = $_POST['username'];
        $password = $_POST['password'];

        // Add user to database
        $userController->createUser($username, $password);

        // Get user info from database
        $user = $userController->getUserLogin($username);

        // Check if password hashes match
        if (password_verify($password, $user['password_hash'])) {
            if (isset($_POST['remember'])) {
                $userController->createAuthCookie($user['id']);
            } else {
                $_SESSION['user_id'] = $user['id'];
            }
            
            redirect('/');
        } else {
            die ('Password hash does not match');
        }
    });

    // Logout user
    $router->get('/logout', function() use ($router) {
        if (isset($_SESSION['user_id'])) {
            session_destroy();
        }
        if (isset($_COOKIE['auth_token'])) {
            setcookie('auth_token', '', 0, '/');
        }
        
        if (!isset($_COOKIE['auth_token']) && !isset($_SESSION['user_id'])) {
            die ('cannot delete login: session and cookie is not set.');
        }
        
        redirect('/');
    });
}