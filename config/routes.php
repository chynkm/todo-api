<?php

use Slim\App;

return function (App $app) {
    $app->get('/tasks/{userId}', \App\Action\TaskListAction::class);
    $app->put('/tasks/{id}/complete', \App\Action\TaskCompleteAction::class);

    $app->get('/docs', \App\Action\SwaggerAction::class);
};
