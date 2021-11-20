<?php
spl_autoload_register(function ($class) {
    $classFile = __DIR__ . "/{$class}.php";
    if (file_exists($classFile)) {
        include $classFile;
    } else {
        die("{$classFile} --- Not Exists!");
    }
});
