<?php

// To help the built-in PHP dev server, check if the request was actually for
// something which should probably be served as a static file
if (PHP_SAPI === 'cli-server' && $_SERVER['SCRIPT_FILENAME'] !== __FILE__) {
    return false;
}

require __DIR__ . '/../../vendor/autoload.php';

// Instantiate the app
$settings = [
    'settings' => [
        // Slim Settings
        'determineRouteBeforeAppMiddleware' => true,
        'displayErrorDetails' => true,

        // monolog settings
        'logger' => [
            'name' => 'app',
            'path' => __DIR__ . '/../log/app.log',
        ],

        //session
        'session' => [
            'name' => 'SlimFramework3',
            'lifetime' => 7200,
            'path' => null,
            'domain' => null,
            'secure' => true,
            'httponly' => true,
            'cache_limiter' => 'nocache',
        ],
    ],
];

$dirPathCache = __DIR__ . '/../cache/slim3-annotation/Cache';

$app = new \Slim\App($settings);

$pathController = __DIR__ . '/../Controller';

\Slim3\Annotation\Slim3Annotation::create($app, $pathController, $dirPathCache);

// Run!
$app->run();
