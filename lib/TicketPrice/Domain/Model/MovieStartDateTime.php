<?php
declare(strict_types=1);

namespace Ngmy\TicketPrice\Domain\Model;

use Ngmy\TicketPrice\Domain\Type\Date\DateTime;

class MovieStartDateTime
{
    /**
     * @var DateTime
     */
    private $value;

    public static function of(DateTime $value): self
    {
        return new self($value);
    }

    public static function ofByString(string $value)
    {
        return new self(DateTime::ofByString($value));
    }

    private function __construct(DateTime $value)
    {
        $this->value = $value;
    }

    public function isWeekday(): bool
    {
        return in_array($this->value->value()->format('w'), ['1', '2', '3', '4', '5']);
    }

    public function isHoliday(): bool
    {
        return in_array($this->value->value()->format('w'), ['0', '6']);
    }

    public function isMovieDay(): bool
    {
        return $this->value->value()->format('j') == '1';
    }

    public function isNormalTime(): bool
    {
        return $this->value->isBefore(DateTime::of($this->value->value()->setTime(20, 0, 0)));
    }

    public function isLateTime(): bool
    {
        return $this->value->isAfter(DateTime::of($this->value->value()->setTime(19, 59, 59)));
    }
}
