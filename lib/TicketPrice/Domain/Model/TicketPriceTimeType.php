<?php
declare(strict_types=1);

namespace Ngmy\TicketPrice\Domain\Model;

use Ngmy\TicketPrice\Domain\Type\Enum\EnumTrait;

/**
 * @method static self normalTimePrice()
 * @method static self lateTimePrice()
 */
class TicketPriceTimeType
{
    use EnumTrait;

    private const ENUM = [
        'normalTimePrice'  => 10,
        'lateTimePrice'    => 20,
    ];

    public function isNormalTimePrice(): bool
    {
        return $this->value() == self::ENUM['normalTimePrice'];
    }

    public function isLateTimePrice(): bool
    {
        return $this->value() == self::ENUM['lateTimePrice'];
    }
}
