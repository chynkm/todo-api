<?php
// Most of the content copied from
// https://www.slimframework.com/docs/v4/objects/application.html#advanced-custom-error-handler

namespace App\Handler;

use App\Exception\ResourceNotFoundException;
use App\Exception\ValidationException;
use Exception;
use Psr\Http\Message\ResponseInterface;
use Slim\Exception\HttpException;
use Slim\Handlers\ErrorHandler;
use Throwable;

class HttpErrorHandler extends ErrorHandler
{
    /**
     * @return ResponseInterface
     */
    protected function respond(): ResponseInterface
    {
        $exception = $this->exception;
        $statusCode = 500;
        $description = 'An internal error has occurred while processing your request.';

        if ($exception instanceof HttpException) {
            $statusCode = $exception->getCode();
            $description = $exception->getMessage();
        }

        if (
            !($exception instanceof HttpException)
            && (
                $exception instanceof Exception
                || $exception instanceof Throwable
            )
            && $this->displayErrorDetails
        ) {
            $description = $exception->getMessage();
        }

        if ($exception instanceof ValidationException) {
            $statusCode = 422;
            $description = $exception->getErrors();
        }

        if ($exception instanceof ResourceNotFoundException) {
            $statusCode = 404;
            $description = $exception->getErrors();
        }

        $error = [
            'statusCode' => $statusCode,
            'message' => $description,
        ];

        $payload = json_encode($error);

        $response = $this->responseFactory->createResponse($statusCode);
        $response->getBody()->write($payload);

        return $response;
    }
}
