<?php
declare (strict_types = 1);

namespace App\Domain\ValueObject;

use App\Exception\ValidationException;
use DateTime;

class MyDate
{
    /**
     * @var string
     */
    private $dateFormat = 'Y-m-d';

    /**
     * @var string
     */
    private $date;

    /**
     * @param string $date
     */
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

    /**
     * @param  string $date
     * @return bool
     */
    private function validateDateFormat(string $date): bool
    {
        $dt = DateTime::createFromFormat($this->dateFormat, $date);
        return $dt && $dt->format($this->dateFormat) == $date;
    }

    /**
     * @return string
     */
    public function getDate(): string
    {
        return $this->date;
    }
}
