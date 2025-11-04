<?php

// Autoloader simple para cargar las clases
spl_autoload_register(function ($class) {
    $directories = [
        __DIR__ . '/model/',
        __DIR__ . '/viewmodel/',
        __DIR__ . '/controller/',
        __DIR__ . '/observer/',
        __DIR__ . '/view/'
    ];

    foreach ($directories as $directory) {
        $file = $directory . $class . '.php';
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});
