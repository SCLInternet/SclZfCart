<?php

$files = array(
    __DIR__ . '/../vendor/autoload.php',        // local autoloader
    __DIR__ . '/../../../vendor/autoload.php',  // module/SclZfCart/tests autoloader
    __DIR__ . '/../../../autoloader.php',       // vendor/sclinternet/scl-zf-cart/tests autoloader
);

foreach ($files as $file) {
    if (file_exists($file)) {
        $loader = require $file;
        break;
    }
}

if (!$loader) {
    throw new \RuntimeError('vendor/autoload.php not found. Have you run composer?');
}

$loader->add('SclZfCartTests\\', __DIR__);

unset($files, $file, $loader);
