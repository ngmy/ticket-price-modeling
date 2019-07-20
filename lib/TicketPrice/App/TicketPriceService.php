<?php
declare(strict_types=1);

namespace Ngmy\TicketPrice\App;

use Ngmy\TicketPrice\Domain\Model\TicketRepositoryInterface;
use Ngmy\TicketPrice\Domain\Model\TicketPriceSpecification;
use Ngmy\TicketPrice\Domain\Model\MovieStartDateTime;

class TicketPriceService
{
    /**
     * @var TicketRepositoryInterface
     */
    private $ticketRepository;

    public function __construct(TicketRepositoryInterface $ticketRepository)
    {
        $this->ticketRepository = $ticketRepository;
    }

    public function getTicketPriceBy(GetTicketPriceByCommand $command): int
    {
        $tickets = $this->ticketRepository->all();

        $spec = new TicketPriceSpecification(
            MovieStartDateTime::ofByString($command->getMovieStartDateTime()),
            $command->getIsThreeDimensionalMovie(),
            $command->getHasThreeDimensionalGlasses(),
            $command->getIsGokubakuScreening()
        );
        $price = $tickets->getApplicableLowestPriceOf($command->getTicketId(), $spec);

        assert(!is_null($price->amount()));
        return $price->amount()->asInt();
    }
}
