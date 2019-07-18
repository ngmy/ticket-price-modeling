<?php
declare(strict_types=1);

namespace Ngmy\TicketPrice\Domain\Model;

use Ngmy\TicketPrice\Domain\Type\Enum\EnumTrait;

class TicketPriceDayType
{
    use EnumTrait;

    private const ENUM = [
        'weekday'  => 10,
        'holiday'  => 20,
        'movieDay' => 30,
    ];

    public function isWeekday(): bool
    {
        return $this->value() == self::ENUM['weekday'];
    }

    public function isHoliday(): bool
    {
        return $this->value() == self::ENUM['holiday'];
    }

    public function isMovieDay(): bool
    {
        return $this->value() == self::ENUM['movieDay'];
    }
}
