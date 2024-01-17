<?php
spl_autoload_register('autoloader');

function autoloader($className) {

    $path = __DIR__ . '/../' . $className . '.php';

    if (file_exists($path)) {
        require_once $path;
    } else {
        error_log("Class not found: $className");
        echo "Something went wrong, Try again later.";
    }
}
