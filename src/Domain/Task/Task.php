<?php
declare (strict_types = 1);

namespace App\Domain\Task;

use App\Domain\ValueObject\MyDate;

class Task
{
    /**
     * @var int|null
     */
    protected $id;

    /**
     * @var int
     */
    protected $userId;

    /**
     * @var string
     */
    protected $description;

    /**
     * @var MyDate
     */
    protected $date;

    /**
     * @var string|null
     */
    protected $completed;

    /**
     * @param int|null      $id
     * @param int           $userId
     * @param string        $description
     * @param MyDate        $date
     * @param string|null   $completed
     */
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

    /**
     * @return int|null
     */
    public function getId() :  ? int
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getUserId() : int
    {
        return $this->userId;
    }

    /**
     * @return string
     */
    public function getDescription() : string
    {
        return $this->description;
    }

    /**
     * @return MyDate
     */
    public function getMyDate(): MyDate
    {
        return $this->date;
    }

    /**
     * @return string|null
     */
    public function getCompleted():  ? string
    {
        return $this->completed;
    }

    /**
     * @return void
     */
    public function markCompleted() : void
    {
        $this->completed = date('Y-m-d H:i:s');
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'userId' => $this->userId,
            'description' => $this->description,
            'date' => $this->getMyDate()->getDate(),
            'completed' => $this->completed,
        ];
    }
}
