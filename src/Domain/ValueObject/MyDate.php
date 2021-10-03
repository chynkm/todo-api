<?php
declare (strict_types = 1);

namespace App\Domain\ValueObject;

use App\Exception\ValidationException;
use DateTime;

class MyDate
{
    private $dateFormat = 'Y-m-d';
    private $date;

    public function __construct(string $date)
    {
        if ($this->validateDateFormat($date) === false) {
            throw new ValidationException(
                'Date format error',
                ['date' => 'Please use YYYY-MM-DD date format.']
            );
        }

        $this->date = $date;
    }

    private function validateDateFormat($date): bool
    {
        $dt = DateTime::createFromFormat($this->dateFormat, $date);
        return $dt && $dt->format($this->dateFormat) == $date;
    }

    public function getDate(): string
    {
        return $this->date;
    }
}
