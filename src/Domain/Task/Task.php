<?php
declare (strict_types = 1);

namespace App\Domain\Task;

use App\Domain\ValueObject\MyDate;

class Task
{
    protected $id;
    protected $userId;
    protected $description;
    protected $date;
    protected $completed;

    public function __construct(
        ? int $id,
        int $userId,
        string $description,
        MyDate $date,
        ? string $completed
    ) {
        $this->id = $id;
        $this->userId = $userId;
        $this->description = $description;
        $this->date = $date;
        $this->completed = $completed;
    }

    public function getId() :  ? int
    {
        return $this->id;
    }

    public function getUserId() : int
    {
        return $this->userId;
    }

    public function getDescription() : string
    {
        return $this->description;
    }

    public function getDate(): MyDate
    {
        return $this->date;
    }

    public function getCompleted():  ? string
    {
        return $this->completed;
    }

    public function markCompleted() : void
    {
        $this->completed = date('Y-m-d H:i:s');
    }

    public function toArray()
    {
        return [
            'id' => $this->id,
            'userId' => $this->userId,
            'description' => $this->description,
            'date' => $this->getDate()->getDate(),
            'completed' => $this->completed,
        ];
    }
}
