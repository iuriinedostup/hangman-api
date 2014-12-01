<?php

function __autoload($class) {
    $namespace = str_replace('\\', DS, $class);
    $classPath = __DIR__ . DS. str_replace('\\', '/', $namespace) . '.php';

    if(is_readable($classPath)) {
        require_once $classPath;
    }
}