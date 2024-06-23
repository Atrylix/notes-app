<?php
function redirect($path) {
    header('Location: ' . SITE_DIR . $path);
    exit();
}

function redirectWithError($path, $error, $variable = null) {
    $queryString = '?error='. $error;
    if ($variable!== null) {
        $queryString.= '&'. http_build_query(array('variable' => $variable));
    }
    header('Location: '. SITE_DIR. $path. $queryString);
    exit();
}