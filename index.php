<?php
// Config scripts
require_once 'config/config.php';
require_once 'config/router.php';
require_once 'config/init.php';

// Controllers
require_once 'controllers/UserController.php';
require_once 'controllers/NoteController.php';
require_once 'controllers/RedirectController.php';

// Routes
require_once 'routes/auth.php';
require_once 'routes/notes.php';

// Create instances
$router = new Router($conn);
$userController = new UserController($conn);
$noteController = new NoteController($conn);

// Run checks
cleanDB($conn);
checkAuthCookie($userController);
setUsername($userController);

// Stylesheet links
$stylesheets = array(
    'normalize' => 'static/styles/normalize.css',
    'styles' => 'static/styles/styles.css',

    'buttonStyles' => 'static/styles/default/button.css',
    'inputStyles' => 'static/styles/default/input.css',
    'navFooterStyles' => 'static/styles/default/nav_footer.css',

    'formStyles' => 'static/styles/customStyles/loginFormStyling.css',
    'noteStyles' => 'static/styles/customStyles/notesStyling.css',
    'settingsStyles' => 'static/styles/customStyles/settingsStyling.css',
    'createStyles' => 'static/styles/customStyles/createStyling.css'
);

// JS links
$scripts = array(
    'loginFormError' => 'static/scripts/loginFormError.js',
    'noteHandler' => 'static/scripts/noteHandler.js',
    'redirectScript' => 'static/scripts/redirect.js'
);

// Path links
$paths = array(
    'site_path' => SITE_PATH
);

// Define routes
$router->get('/', function () use ($router, $noteController) {
    global $stylesheets;
    global $scripts;
    
    if (isset($_SESSION['user_id'])) {        
        $notes = $noteController->loadNotes();
        
        $_SESSION['notes'] = $notes;
        
        echo $router->render_template('main.php', $stylesheets, $scripts);

        unset($_SESSION['notes']);
    }  else {
        redirect('/login');
    }
});

$router->get('/settings', function () use ($router) {
    global $stylesheets;
    global $scripts;

    if (isset($_SESSION['user_id'])) {
        echo $router->render_template('settings.php', $stylesheets, $scripts);
    }  else {
        redirect('/login');
    }
});

note_routes($router, $userController, $noteController);

auth_routes($router, $userController);

// Run the router
$router->run();