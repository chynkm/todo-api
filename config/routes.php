<?php

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\App;

$app->get('/tasks/{userId}', \App\Action\TaskListAction::class);
$app->put('/tasks/{id}/complete', \App\Action\TaskCompleteAction::class);

return function (App $app) {
    $app->get('/', function (
        ServerRequestInterface $request,
        ResponseInterface $response
    ) {
        $response->getBody()->write('Hello, World!');

        return $response;
    });
};
