<?php
declare (strict_types = 1);

namespace App\Service\Task;

use App\Domain\Task\TaskRepository;
use App\Domain\ValueObject\MyDate;

final class TaskLister
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
     * @param  int    $userId
     * @param  string $date
     * @return array<int, array>
     */
    public function listTasks(int $userId, string $date): array
    {
        $myDate = new MyDate($date);
        $tasks = $this->repository
            ->findByUserIdAndDate($userId, $myDate);

        $data = [];
        foreach ($tasks as $task) {
            $data[] = $task->toArray();
        }

        return $data;
    }
}
