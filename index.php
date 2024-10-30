<?php
include 'system/autoload.php';

// Checking cookies once, when user first visiting web service, do nothing if cookie is checked
if (!isset($_SESSION['cookie_checked']) or !$_SESSION['cookie_checked']) {
    // Set a session flag to know if the cookie is checked
    $_SESSION['cookie_checked'] = true;

    // Checking cookie and set required values
    if (isset($_COOKIE['remember'])) {
        $_SESSION['login_status'] = 1;
        $_SESSION['id'] = $_COOKIE['id'];
        $_SESSION['name'] = $_COOKIE['name'];
        $_SESSION['email'] = $_COOKIE['email'];
        $_SESSION['avatar'] = $_COOKIE['avatar'];
        $_SESSION['permission'] = $_COOKIE['permission'];
    }
}

$action = $_GET["action"] ?? 'index';
$controller_name = ($_GET["cont"] ?? 'System').'Controller';
if (class_exists($controller_name)) {
    $controller = new $controller_name();
    if (method_exists($controller, $action)) {
        $controller->$action();
    } else {
        $controller->_404();
    }
} else {
    $controller = new Controller();
    $controller->_404();
}
ob_end_flush();