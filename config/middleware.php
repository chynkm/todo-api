<?php

use App\Handler\HttpErrorHandler;
use Slim\App;

return function (App $app) {
    // Parse json, form data and xml
    $app->addBodyParsingMiddleware();

    // Add the Slim built-in routing middleware
    $app->addRoutingMiddleware();

    $callableResolver = $app->getCallableResolver();
    $responseFactory = $app->getResponseFactory();
    $errorHandler = new HttpErrorHandler($callableResolver, $responseFactory);

    // Add Error Handling Middleware
    $errorMiddleware = $app->addErrorMiddleware(true, false, false);
    $errorMiddleware->setDefaultErrorHandler($errorHandler);
};
