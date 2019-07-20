<?php
declare(strict_types=1);

namespace Ngmy\TicketPrice\Domain\Model;

use Ngmy\TicketPrice\Domain\Type\Enum\EnumTrait;

/**
 * @method static self weekday()
 * @method static self holiday()
 * @method static self movieDay()
 */
class TicketPriceDayType
{
    use EnumTrait;

    private const ENUM = [
        'weekday'  => 10,
        'holiday'  => 20,
        'movieDay' => 30,
    ];

    public function isWeekdayPrice(): bool
    {
        return $this->value() == self::ENUM['weekday'];
    }

    public function isHolidayPrice(): bool
    {
        return $this->value() == self::ENUM['holiday'];
    }

    public function isMovieDayPrice(): bool
    {
        return $this->value() == self::ENUM['movieDay'];
    }
}
