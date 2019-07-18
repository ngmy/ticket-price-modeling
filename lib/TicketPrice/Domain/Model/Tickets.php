<?php
declare(strict_types=1);

namespace Ngmy\TicketPrice\Domain\Model;

class Tickets
{
    /**
     * @var Ticket[]
     */
    private $tickets = [];

    public static function of(array $tickets): self
    {
        return new self($tickets);
    }

    public function getApplicablePricesOf(int $id, TicketPriceSpecification $spec): TicketPrices
    {
        foreach ($this->tickets as $ticket) {
            if ($ticket->id() == $id) {
                return $ticket->getApplicablePrices($spec);
            }
        }

        return TicketPrices::empty();
    }

    public function getApplicableLowestPriceOf(int $id, TicketPriceSpecification $spec): TicketPrice
    {
        foreach ($this->tickets as $ticket) {
            if ($ticket->id() == $id) {
                return $ticket->getApplicableLowestPrice($spec);
            }
        }
    }

    private function __construct(array $tickets)
    {
        foreach ($tickets as $ticket) {
            $this->addTicket($ticket);
        }
    }

    private function addTicket(Ticket $ticket): void
    {
        $this->tickets[] = $ticket;
    }
}
