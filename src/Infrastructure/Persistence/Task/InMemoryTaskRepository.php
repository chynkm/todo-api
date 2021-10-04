<?php
declare (strict_types = 1);

namespace App\Infrastructure\Persistence\Task;

use App\Domain\Task\Task;
use App\Domain\Task\TaskNotFoundException;
use App\Domain\Task\TaskRepository;
use App\Domain\User\UserNotFoundException;
use App\Domain\ValueObject\MyDate;

class InMemoryTaskRepository implements TaskRepository
{
    private $tasks;

    public function __construct(array $tasks = null)
    {
        $this->tasks = $tasks ?? [
            1 => new Task(1, 1, 'First task', new MyDate('2021-10-01'), null),
            2 => new Task(2, 1, 'Second task', new MyDate('2021-09-04'), null),
            3 => new Task(3, 1, 'Third task', new MyDate('2021-10-01'), null),
            4 => new Task(4, 1, 'Fourth task', new MyDate('2021-09-22'), null),
            5 => new Task(5, 5, 'Fifth task', new MyDate('2021-10-01'), null),
            6 => new Task(6, 5, 'Sixth task', new MyDate('2021-09-27'), '2021-09-27 14:33:33'),
            7 => new Task(7, 11, 'Seventh task', new MyDate('2021-10-01'), null),
            8 => new Task(8, 11, 'Eigth task', new MyDate('2021-10-11'), null),
        ];
    }

    public function findByUserIdAndDate(int $userId, MyDate $date): array
    {
        $this->existsUserId($userId);

        $tasks = array_filter($this->tasks,
            function ($task) use ($userId, $date) {
                return $task->getUserId() == $userId
                && $task->getDate() == $date;
            });

        return array_values($tasks);
    }

    public function findById(int $id): Task
    {
        if (!isset($this->tasks[$id])) {
            throw new TaskNotFoundException();
        }

        return $this->tasks[$id];
    }

    public function markCompletedById(int $id): Task
    {
        if (!isset($this->tasks[$id])) {
            throw new TaskNotFoundException();
        }

        $this->tasks[$id]->markCompleted();
        return $this->tasks[$id];
    }

    public function existsUserId(int $userId): void
    {
        $tasks = array_filter($this->tasks,
            function ($task) use ($userId) {
                return $task->getUserId() == $userId;
            });

        if ((bool) $tasks === false) {
            throw new UserNotFoundException();
        }
    }
}
