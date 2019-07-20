<?php
declare(strict_types=1);

namespace Ngmy\TicketPrice\Domain\Model;

use Ngmy\TicketPrice\Domain\Type\Enum\EnumTrait;

/**
 * @method static self weekdayPrice()
 * @method static self holidayPrice()
 * @method static self movieDayPrice()
 */
class TicketPriceDayType
{
    use EnumTrait;

    private const ENUM = [
        'weekdayPrice'  => 10,
        'holidayPrice'  => 20,
        'movieDayPrice' => 30,
    ];

    public function isWeekdayPrice(): bool
    {
        return $this->value() == self::ENUM['weekdayPrice'];
    }

    public function isHolidayPrice(): bool
    {
        return $this->value() == self::ENUM['holidayPrice'];
    }

    public function isMovieDayPrice(): bool
    {
        return $this->value() == self::ENUM['movieDayPrice'];
    }
}
