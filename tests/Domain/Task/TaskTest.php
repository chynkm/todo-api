<?php
declare (strict_types = 1);

namespace App\Test\Domain\Task;

use App\Domain\Task\Task;
use App\Domain\ValueObject\MyDate;
use PHPUnit\Framework\TestCase;

class TaskTest extends TestCase
{
    /**
     * @return array<int, array>
     */
    public function taskProvider(): array
    {
        return [
            [1, 1, 'First task', new MyDate('2021-10-01'), null],
            [2, 1, 'Second task', new MyDate('2021-09-04'), null],
            [3, 1, 'Third task', new MyDate('2021-10-01'), null],
            [4, 1, 'Fourth task', new MyDate('2021-09-22'), null],
            [5, 5, 'Fifth task', new MyDate('2021-10-01'), null],
            [6, 5, 'Sixth task', new MyDate('2021-09-27'), '2021-09-27 14:33:33'],
            [7, 11, 'Seventh task', new MyDate('2021-10-01'), null],
            [8, 11, 'Eigth task', new MyDate('2021-10-11'), null],
        ];
    }

    /**
     * @dataProvider taskProvider
     *
     * @param int    $id
     * @param int    $userId
     * @param string $description
     * @param MyDate $date
     * @param string $completed
     */
    public function testGetters(
        int $id,
        int $userId,
        string $description,
        MyDate $date,
        ? string $completed
    ) : void{
        $task = new Task($id, $userId, $description, $date, $completed);

        $this->assertEquals($id, $task->getId());
        $this->assertEquals($userId, $task->getUserId());
        $this->assertEquals($description, $task->getDescription());
        $this->assertEquals($date, $task->getMyDate());
        $this->assertEquals($completed, $task->getCompleted());
    }

    public function testMarkCompleted(): void
    {
        $task = new Task(1, 1, 'First task', new MyDate('2021-10-01'), null);

        $task->markCompleted();
        $this->assertNotNull($task->getCompleted());
    }

    public function testTaskToArray(): void
    {
        $task = new Task(1, 1, 'First task', new MyDate('2021-10-01'), null);
        $got = $task->toArray();
        $want = [
            'id' => 1,
            'userId' => 1,
            'description' => 'First task',
            'date' => (new MyDate('2021-10-01'))->getDate(),
            'completed' => null,
        ];

        $this->assertEquals($got, $want);
    }

}
