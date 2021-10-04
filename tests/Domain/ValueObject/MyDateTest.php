<?php
declare (strict_types = 1);

namespace App\Test\Domain\ValueObject;

use App\Domain\ValueObject\MyDate;
use App\Exception\ValidationException;
use PHPUnit\Framework\TestCase;

class MyDateTest extends TestCase
{
    /**
     * @return array<int, array>
     */
    public function invalidDatesProvider(): array
    {
        return [
            ['2342'],
            [''],
            ['2021-022-00'],
            ['2021-2021'],
            ['asdfasdf'],
            ['10-12-2021'],
            ['12-10-2021'],
        ];
    }

    /**
     * @dataProvider invalidDatesProvider
     */
    public function testInvalidDateFormat(string $invalidDate): void
    {
        $this->expectException(ValidationException::class);
        new MyDate($invalidDate);
    }

    /**
     * @return array<int, array>
     */
    public function validDatesProvider(): array
    {
        return [
            [date('Y-m-d')],
            [date('Y-m-d', strtotime('+1 day'))], //future date
        ];
    }

    /**
     * @dataProvider validDatesProvider
     */
    public function testValidDateFormat(string $validDate): void
    {
        $myDate = new MyDate($validDate);
        $this->assertEquals($validDate, $myDate->getDate());
    }
}
