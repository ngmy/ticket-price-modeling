<?php
declare(strict_types=1);

namespace Ngmy\TicketPrice\Domain\Model;

use Ngmy\TicketPrice\Domain\Type\Money\Money;

class TicketPriceSpecification
{
    private const THREE_DIMENSIONAL_MOVIE_PRICE = 400;

    private const HAS_THREE_THREE_DIMENSIONAL_GLASSES_DISCOUNT = 100;

    /**
     * @var MovieStartDateTime
     */
    private $movieStartDateTime;

    /**
     * @var bool
     */
    private $isThreeDimensionalMovie;

    /**
     * @var bool
     */
    private $hasThreeDimensionalGlasses;

    /**
     * @var bool
     */
    private $isGokubakuScreening;

    public function __construct(
        MovieStartDateTime $movieStartDateTime,
        bool $isThreeDimensionalMovie,
        bool $hasThreeDimensionalGlasses,
        bool $isGokubakuScreening
    ) {
        $this->movieStartDateTime = $movieStartDateTime;
        $this->isThreeDimensionalMovie = $isThreeDimensionalMovie;
        $this->hasThreeDimensionalGlasses = $hasThreeDimensionalGlasses;
        $this->isGokubakuScreening = $isGokubakuScreening;
    }

    public function isSatisfiedBy(TicketPrice $price): bool
    {
        return !is_null($price->amount()) && (
            (
                $price->type()->dayType()->isMovieDayPrice() && $price->type()->timeType()->isLateTimePrice() &&
                $this->movieStartDateTime->isMovieDay() && $this->movieStartDateTime->isLateTime()
            ) ||
            (
                $price->type()->dayType()->isMovieDayPrice() && $price->type()->timeType()->isNormalTimePrice() &&
                $this->movieStartDateTime->isMovieDay()
            ) ||
            (
                !$this->isGokubakuScreening &&
                $price->type()->dayType()->isHolidayPrice() && $price->type()->timeType()->isLateTimePrice() &&
                $this->movieStartDateTime->isHoliday() && $this->movieStartDateTime->isLateTime()
            ) ||
            (
                $price->type()->dayType()->isHolidayPrice() && $price->type()->timeType()->isNormalTimePrice() &&
                $this->movieStartDateTime->isHoliday()
            ) ||
            (
                !$this->isGokubakuScreening &&
                $price->type()->dayType()->isWeekdayPrice() && $price->type()->timeType()->isLateTimePrice() &&
                $this->movieStartDateTime->isWeekday() && $this->movieStartDateTime->isLateTime()
            ) ||
            (
                $price->type()->dayType()->isWeekdayPrice() && $price->type()->timeType()->isNormalTimePrice() &&
                $this->movieStartDateTime->isWeekday()
            )
        );
    }

    public function applyTo(TicketPrice $price): TicketPrice
    {
        if ($this->isThreeDimensionalMovie) {
            $threeDimensionalPrice = Money::of(self::THREE_DIMENSIONAL_MOVIE_PRICE);
            if ($this->hasThreeDimensionalGlasses) {
                $threeDimensionalPrice = $threeDimensionalPrice->minus(
                    Money::of(self::HAS_THREE_THREE_DIMENSIONAL_GLASSES_DISCOUNT)
                );
            }
            $price = $price->add($threeDimensionalPrice);
        }
        return $price;
    }
}
