<?php
declare (strict_types = 1);

namespace App\Test\Infrastructure\Persistence\Task;

use App\Domain\Task\Task;
use App\Domain\Task\TaskNotFoundException;
use App\Domain\User\UserNotFoundException;
use App\Domain\ValueObject\MyDate;
use App\Infrastructure\Persistence\Task\InMemoryTaskRepository;
use PHPUnit\Framework\TestCase;

class InMemoryTaskRepositoryTest extends TestCase
{

    public function testFindById(): void
    {
        $task = new Task(1, 1, 'First task', new MyDate('2021-10-01'), null);

        $taskRepository = new InMemoryTaskRepository([1 => $task]);

        $this->assertEquals($task, $taskRepository->findById(1));
    }

    public function testFindAllTasksOfAUserForADate(): void
    {
        $tasks = [
            1 => new Task(1, 1, 'First task', new MyDate('2021-10-01'), null),
            2 => new Task(2, 1, 'Second task', new MyDate('2021-09-04'), null),
            3 => new Task(3, 1, 'Third task', new MyDate('2021-10-01'), null),
            4 => new Task(4, 4, 'Fourth task', new MyDate('2021-09-22'), null),
            5 => new Task(5, 5, 'Fifth task', new MyDate('2021-09-27'), null),
            6 => new Task(6, 5, 'Sixth task', new MyDate('2021-09-27'), '2021-09-27 14:33:33'),
            7 => new Task(7, 11, 'Seventh task', new MyDate('2021-10-01'), null),
            8 => new Task(8, 11, 'Eigth task', new MyDate('2021-10-11'), null),
        ];
        $taskRepository = new InMemoryTaskRepository($tasks);

        $this->assertEquals(
            [$tasks[4]],
            $taskRepository->findByUserIdAndDate(4, new MyDate('2021-09-22'))
        );

        $user5Tasks = [];
        array_push($user5Tasks, $tasks[5]);
        array_push($user5Tasks, $tasks[6]);

        $this->assertEquals(
            $user5Tasks,
            $taskRepository->findByUserIdAndDate(5, new MyDate('2021-09-27'))
        );
    }

    public function testFindByIdThrowsNotFoundException(): void
    {
        $taskRepository = new InMemoryTaskRepository([]);
        $this->expectException(TaskNotFoundException::class);
        $taskRepository->findById(1);
    }

    public function testFindByUserIdThrowsNotFoundException(): void
    {
        $task = new Task(1, 1, 'First task', new MyDate('2021-10-01'), null);
        $taskRepository = new InMemoryTaskRepository([1 => $task]);
        $this->expectException(UserNotFoundException::class);
        $taskRepository->existsUserId(2);
    }

    public function testCompleteById(): void
    {
        $task = new Task(1, 1, 'First task', new MyDate('2021-10-01'), null);
        $taskRepository = new InMemoryTaskRepository([1 => $task]);

        $completedTask = $taskRepository->markCompletedById(1);

        $this->assertEquals($task->getId(), $completedTask->getId());
        $this->assertEquals($task->getDescription(), $completedTask->getDescription());
        $this->assertNotNull($completedTask->getCompleted());
    }

    public function testCompleteByIdThrowsNotFoundException(): void
    {
        $taskRepository = new InMemoryTaskRepository([]);
        $this->expectException(TaskNotFoundException::class);
        $taskRepository->markCompletedById(1);
    }

}
