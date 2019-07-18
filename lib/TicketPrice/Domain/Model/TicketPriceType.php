<?php
declare(strict_types=1);

namespace Ngmy\TicketPrice\Domain\Model;

class TicketPriceType
{
    /**
     * @var TicketPriceDayType
     */
    private $dayType;

    /**
     * @var TicketPriceTimeType
     */
    private $timeType;

    public static function of(TicketPriceDayType $dayType, TicketPriceTimeType $timeType): self
    {
        return new self($dayType, $timeType);
    }

    public function dayType(): TicketPriceDayType
    {
        return $this->dayType;
    }

    public function timeType(): TicketPriceTimeType
    {
        return $this->timeType;
    }

    private function __construct(TicketPriceDayType $dayType, TicketPriceTimeType $timeType)
    {
        $this->dayType = $dayType;
        $this->timeType = $timeType;
    }
}
