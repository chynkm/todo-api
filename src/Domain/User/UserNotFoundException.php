<?php
declare (strict_types = 1);

namespace App\Domain\User;

class UserNotFoundException extends \Exception
{
    public function getErrors(): array
    {
        return ['user_id' => 'The user you requested does not exist.'];
    }
}
