<?php
spl_autoload_register('autoloader');

function autoloader($className) {
    $controllerPath = __DIR__ . '/../controllers/' . $className . '.php';
    $modelPath = __DIR__ . '/../models/' . $className . '.php';

    if (file_exists($controllerPath)) {
        require_once $controllerPath;
    } elseif (file_exists($modelPath)) {
        require_once $modelPath;
    } else {
        throw new Exception("Class not found: $className");
    }
}
