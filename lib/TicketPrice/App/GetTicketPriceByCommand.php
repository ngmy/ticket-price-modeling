<?php
declare(strict_types=1);

namespace Ngmy\TicketPrice\App;

class GetTicketPriceByCommand
{
    /**
     * @var int
     */
    private $ticketId;

    /**
     * @var string
     */
    private $movieStartDateTime;

    /**
     * @var bool
     */
    private $isThreeDimensionalMovie = false;

    /**
     * @var bool
     */
    private $hasThreeDimensionalGlasses = false;

    /**
     * @var bool
     */
    private $isGokubakuScreening = false;

    public function __construct(int $ticketId, string $movieStartDateTime)
    {
        $this->ticketId = $ticketId;
        $this->movieStartDateTime = $movieStartDateTime;
    }

    public function setIsThreeDimensionalMovie(bool $isThreeDimensionalMovie): self
    {
        $this->isThreeDimensionalMovie = $isThreeDimensionalMovie;
        return $this;
    }

    public function setHasThreeDimensionalGlasses(bool $hasThreeDimensionalGlasses): self
    {
        $this->hasThreeDimensionalGlasses = $hasThreeDimensionalGlasses;
        return $this;
    }

    public function setIsGokubakuScreening(bool $isGokubakuScreening): self
    {
        $this->isGokubakuScreening = $isGokubakuScreening;
        return $this;
    }

    public function getTicketId(): int
    {
        return $this->ticketId;
    }

    public function getMovieStartDateTime(): string
    {
        return $this->movieStartDateTime;
    }

    public function getIsThreeDimensionalMovie(): bool
    {
        return $this->isThreeDimensionalMovie;
    }

    public function getHasThreeDimensionalGlasses(): bool
    {
        return $this->hasThreeDimensionalGlasses;
    }

    public function getIsGokubakuScreening(): bool
    {
        return $this->isGokubakuScreening;
    }
}
