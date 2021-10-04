<?php
declare (strict_types = 1);

namespace App\Action;

use App\Service\Task\TaskLister;
use Fig\Http\Message\StatusCodeInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class TaskListAction
{
    /**
     * @var TaskLister
     */
    private $taskLister;

    /**
     * @param TaskLister $taskLister
     */
    public function __construct(TaskLister $taskLister)
    {
        $this->taskLister = $taskLister;
    }

    /**
     * @param  ServerRequestInterface $request
     * @param  ResponseInterface      $response
     * @param  array<string, string>  $args
     * @return ResponseInterface
     * @throws \App\Domain\User\UserNotFoundException
     */
    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args
    ): ResponseInterface{
        $userId = (int) $args['userId'];
        $queryParams = $request->getQueryParams();
        $date = $queryParams['date'] ?? date('Y-m-d');

        $rows = $this->taskLister->listTasks($userId, $date);

        $response->getBody()
            ->write((string) json_encode($rows));

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(StatusCodeInterface::STATUS_OK);
    }
}
