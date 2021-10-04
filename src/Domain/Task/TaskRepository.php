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
     * @throws \App\Domain\Task\TaskNotFoundException
     */
    public function findById(int $id): Task;

    /**
     * @return Task[]
     */
    public function findByUserIdAndDate(int $userId, MyDate $date): array;

    /**
     * @param int $id
     * @return Task
     * @throws \App\Domain\Task\TaskNotFoundException
     */
    public function markCompletedById(int $id): Task;

    /**
     * @param int $userId
     * @return void
     * @throws \App\Domain\User\UserNotFoundException
     */
    public function existsUserId(int $userId): void;
}
