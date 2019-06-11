<?php

call_user_func(function () {
    $autoloadFile = __DIR__ . '/vendor/autoload.php';

    if (!is_file($autoloadFile)) {
        throw new \RuntimeException('Did not find vendor/autoload.php. Did you run "composer install"?');
    }

    /** @noinspection PhpIncludeInspection */
    require_once $autoloadFile;

    ini_set('date.timezone', 'Europe/Moscow');
});
