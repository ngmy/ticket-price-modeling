<?php
declare(strict_types=1);

namespace Ngmy\TicketPrice\Domain\Model;

class Ticket
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var TicketPrices
     */
    private $prices;

    /**
     * @var string
     */
    private $remark;

    public static function of(int $id, string $name, TicketPrices $prices, string $remark): self
    {
        return new self($id, $name, $prices, $remark);
    }

    public function getApplicablePrices(TicketPriceSpecification $spec): TicketPrices
    {
        return $this->prices->getApplicablePrices($spec);
    }

    public function getApplicableLowestPrice(TicketPriceSpecification $spec): TicketPrice
    {
        return $this->prices->getApplicableLowestPrice($spec);
    }

    public function equals($object): bool
    {
        $equalsObject = false;

        if (!is_null($object) && $object instanceof self) {
            $equalsObject = $this->id == $object->id;
        }

        return $equalsObject;
    }

    public function id(): int
    {
        return $this->id;
    }

    private function __construct(int $id, string $name, TicketPrices $prices, string $remark)
    {
        $this->id = $id;
        $this->name = $name;
        $this->prices = $prices;
        $this->remark = $remark;
    }
}
