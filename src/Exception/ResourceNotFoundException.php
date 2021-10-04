<?php
declare (strict_types = 1);

namespace App\Exception;

use Exception;
use Throwable;

class ResourceNotFoundException extends \Exception
{
    /**
     * @var array<string, string>
     */
    private $errors;

    /**
     * @param string                $message
     * @param array<string, string> $errors
     * @param int|integer           $code
     * @param Throwable|null        $previous
     */
    public function __construct(
        string $message,
        array $errors = [],
        int $code = 404,
        Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);

        $this->errors = $errors;
    }

    /**
     * @return array<string, string>
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

}
