<?php
class Controller {
    function show($view, $data = null,  $layout = 'SharedLayout') {
        include 'View/'.$layout.'.php';
    }

    function _403() {
        include 'View/system/403.php';
    }
    function _404() {
        include 'View/system/404.php';
    }
    function _500() {
        include 'View/system/500.php';
    }
}