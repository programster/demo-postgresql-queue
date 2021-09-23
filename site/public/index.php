<?php

require_once(__DIR__ . '/../vendor/autoload.php');

$app = Slim\Factory\AppFactory::create();
$app->addErrorMiddleware($displayErrorDetails=true, $logErrors=true, $logErrorDetails=true);

$app->get('/', function (Psr\Http\Message\ServerRequestInterface $request, Psr\Http\Message\ResponseInterface $response) {
    $body = $response->getBody();
    $body->write('Hello world'); // returns number of bytes written
    $newResponse = $response->withBody($body);
    return $newResponse;
});

$app->run();