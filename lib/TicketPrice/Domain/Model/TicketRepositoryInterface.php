<?php
declare(strict_types=1);

namespace Ngmy\TicketPrice\Domain\Model;

interface TicketRepositoryInterface
{
    public function all(): Tickets;
}
