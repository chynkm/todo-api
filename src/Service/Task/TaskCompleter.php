<?php
declare (strict_types = 1);

namespace App\Service\Task;

use App\Domain\Task\TaskRepository;

final class TaskCompleter
{
    /**
     * @var TaskRepository
     */
    private $repository;

    /**
     * @param TaskRepository $repository
     */
    public function __construct(TaskRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param  int    $id
     * @return array<string, mixed>
     */
    public function completeTask(int $id): array
    {
        $task = $this->repository->markCompletedById($id);
        return $task->toArray();
    }
}
