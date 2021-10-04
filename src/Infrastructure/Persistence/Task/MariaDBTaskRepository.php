<?php
declare (strict_types = 1);

namespace App\Infrastructure\Persistence\Task;

use App\Domain\Task\Task;
use App\Domain\Task\TaskNotFoundException;
use App\Domain\Task\TaskRepository;
use App\Domain\User\UserNotFoundException;
use App\Domain\ValueObject\MyDate;
use Doctrine\DBAL\Connection;

class MariaDBTaskRepository implements TaskRepository
{
    /**
     * @var Connection
     */
    private $connection;

    /**
     * @param Connection $connection
     */
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @param  int    $id
     * @return Task
     * @throws \App\Domain\Task\TaskNotFoundException
     */
    public function findById(int $id): Task
    {
        $query = $this->connection->createQueryBuilder();

        $row = $query
            ->select('id', 'user_id', 'description', 'date', 'completed')
            ->from('tasks')
            ->where('id = :id')
            ->setParameter('id', $id)
            ->execute()
            ->fetch();

        if ((bool) $row === false) {
            throw new TaskNotFoundException(
                'Requested Task not found',
                ['id' => 'The task you requested does not exist.']
            );
        }

        return new Task(
            (int) $row['id'],
            (int) $row['user_id'],
            $row['description'],
            new MyDate($row['date']),
            $row['completed'],
        );
    }

    /**
     * @return Task[]
     */
    public function findByUserIdAndDate(int $userId, MyDate $date): array
    {
        $this->existsUserId($userId);
        $query = $this->connection->createQueryBuilder();

        $rows = $query
            ->select('id', 'user_id', 'description', 'date', 'completed')
            ->from('tasks')
            ->where('user_id = :userId')
            ->setParameter('userId', $userId)
            ->andWhere('date = :date')
            ->setParameter('date', $date->getDate())
            ->orderBy('completed', 'ASC')
            ->execute()
            ->fetchAll();

        $tasks = [];
        foreach ($rows as $row) {
            $tasks[] = new Task(
                (int) $row['id'],
                (int) $row['user_id'],
                $row['description'],
                new MyDate($row['date']),
                $row['completed'],
            );
        }

        return $tasks;
    }

    /**
     * @param int $id
     * @return Task
     * @throws \App\Domain\Task\TaskNotFoundException
     */
    public function markCompletedById(int $id): Task
    {
        $query = $this->connection->createQueryBuilder();

        $row = $query->select('id')
            ->from('tasks')
            ->where('id = :id')
            ->setParameter('id', $id)
            ->execute()
            ->fetch();

        if ((bool) $row === false) {
            throw new TaskNotFoundException(
                'Requested Task not found',
                ['id' => 'The task you requested does not exist.']
            );
        }

        $this->connection->update('tasks', [
            'completed' => date('Y-m-d H:i:s'),
        ], ['id' => $id]);

        return $this->findById($id);
    }

    /**
     * @param int $userId
     * @return void
     * @throws \App\Domain\User\UserNotFoundException
     */
    public function existsUserId(int $userId): void
    {
        $query = $this->connection->createQueryBuilder();

        $row = $query->select('id')
            ->from('tasks')
            ->where('user_id = :userId')
            ->setParameter('userId', $userId)
            ->execute()
            ->fetch();

        if ((bool) $row === false) {
            throw new UserNotFoundException(
                'Requested User not found',
                ['userId' => 'The user you requested does not exist.']
            );
        }
    }
}
