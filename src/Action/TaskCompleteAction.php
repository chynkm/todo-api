<?php
declare (strict_types = 1);

namespace App\Action;

use App\Service\Task\TaskCompleter;
use Fig\Http\Message\StatusCodeInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class TaskCompleteAction
{
    /**
     * @var TaskCompleter
     */
    private $taskCompleter;

    /**
     * @param TaskCompleter $taskCompleter
     */
    public function __construct(TaskCompleter $taskCompleter)
    {
        $this->taskCompleter = $taskCompleter;
    }

    /**
     * @param  ServerRequestInterface $request
     * @param  ResponseInterface      $response
     * @param  array<string, string>  $args
     * @return ResponseInterface
     * @throws \App\Domain\Task\TaskNotFoundException
     */
    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args
    ): ResponseInterface{
        $taskId = (int) $args['id'];

        $task = $this->taskCompleter->completeTask($taskId);
        $response->getBody()
            ->write((string) json_encode($task));

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(StatusCodeInterface::STATUS_OK);
    }
}
