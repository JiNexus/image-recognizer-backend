<?php

declare(strict_types=1);

use Dotenv\Dotenv;

/**
 * Self-called anonymous function that creates its own scope and keeps the global namespace clean.
 */
(function () {
    $dotenv = Dotenv::createUnsafeImmutable(dirname(__DIR__));
    $dotenv->load();
    $dotenv->required([
        'APP_ENV',
        'DATABASE_HOST',
        'DATABASE_NAME',
        'DATABASE_USER',
        'DATABASE_PASSWORD',
    ])->notEmpty();
})();
