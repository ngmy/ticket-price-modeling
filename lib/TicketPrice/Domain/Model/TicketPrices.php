<?php
declare(strict_types=1);

namespace Ngmy\TicketPrice\Domain\Model;

use Ngmy\TicketPrice\Domain\Type\Money\Money;

class TicketPrices
{
    /**
     * @var TicketPrice[]
     */
    private $prices = [];

    public static function of(array $prices): self
    {
        return new self($prices);
    }

    public static function empty(): self
    {
        return new self([]);
    }

    public function getApplicablePrices(TicketPriceSpecification $spec): TicketPrices
    {
        return new self(array_reduce($this->prices, function (array $carry, TicketPrice $price) use ($spec) {
            if (!$spec->isSatisfiedBy($price)) {
                return $carry;
            };
            $carry[] = $spec->applyTo($price);
            return $carry;
        }, []));
    }

    public function getApplicableLowestPrice(TicketPriceSpecification $spec): TicketPrice
    {
        $result = null;
        $resultAmount = Money::of(PHP_INT_MAX);
        foreach ($this->getApplicablePrices($spec)->prices as $price) {
            if ($price->amount()->isLess($resultAmount)) {
                $result = $price;
                $resultAmount = $price->amount();
            }
        }
        return $result;
    }

    private function __construct(array $prices)
    {
        foreach ($prices as $price) {
            $this->addTicketPrice($price);
        }
    }

    private function addTicketPrice(TicketPrice $price): void
    {
        $this->prices[] = $price;
    }
}
