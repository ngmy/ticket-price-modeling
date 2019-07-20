<?php
declare(strict_types=1);

namespace Ngmy\TicketPrice\Domain\Model;

use Ngmy\TicketPrice\Domain\Type\Enum\EnumTrait;

class TicketPriceTimeType
{
    use EnumTrait;

    private const ENUM = [
        'normal'  => 10,
        'late'    => 20,
    ];

    public function isNormalTimePrice(): bool
    {
        return $this->value() == self::ENUM['normal'];
    }

    public function isLateTimePrice(): bool
    {
        return $this->value() == self::ENUM['late'];
    }
}
