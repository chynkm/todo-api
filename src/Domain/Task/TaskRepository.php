<?php
declare (strict_types = 1);

namespace App\Domain\Task;

use App\Domain\Task\Task;
use App\Domain\ValueObject\MyDate;

interface TaskRepository
{
    /**
     * @param int $id
     * @return Task
     * @throws TaskNotFoundException
     */
    public function findById(int $id): Task;

    /**
     * @return Task[]
     */
    public function findByUserId(int $userId, MyDate $date): array;

    /**
     * @param int $id
     * @return Task
     * @throws TaskNotFoundException
     */
    public function markCompletedById(int $id): Task;
}
