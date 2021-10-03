<?php
declare (strict_types = 1);

namespace App\Domain\Task;

class TaskNotFoundException extends \Exception
{
    public function getErrors(): array
    {
        return ['id' => 'The task you requested does not exist.'];
    }
}
