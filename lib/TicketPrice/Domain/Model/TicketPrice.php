<?php
declare(strict_types=1);

namespace Ngmy\TicketPrice\Domain\Model;

use Ngmy\TicketPrice\Domain\Type\Money\Money;

class TicketPrice
{
    /**
     * @var Money|null
     */
    private $amount;

    /**
     * @var TicketPriceType
     */
    private $type;

    public static function of(?Money $amount, TicketPriceType $type): self
    {
        return new self($amount, $type);
    }

    public function add(Money $amount): self
    {
        if (is_null($this->amount)) {
            return $this;
        }
        $amount = $this->amount->plus($amount);
        return new self($amount, $this->type);
    }

    public function subtract(Money $amount): self
    {
        if (is_null($this->amount)) {
            return $this;
        }
        $amount = $this->amount->minus($amount);
        return new self($amount, $this->type);
    }

    public function asInt(): int
    {
        if (is_null($this->amount)) {
            return 0;
        }
        return $this->amount->asInt();
    }

    public function amount(): ?Money
    {
        return $this->amount;
    }

    public function type(): TicketPriceType
    {
        return $this->type;
    }

    private function __construct(?Money $amount, TicketPriceType $type)
    {
        $this->amount = $amount;
        $this->type = $type;
    }
}
