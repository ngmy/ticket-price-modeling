<?php
declare(strict_types=1);

namespace Ngmy\TicketPrice\Domain\Type\Date;

use DateTimeImmutable;

class DateTime
{
    /**
     * @var DateTimeImmutable
     */
    private $value;

    public static function of(DateTimeImmutable $value): self
    {
        return new self($value);
    }

    public static function ofByString(string $value): self
    {
        return new self(new DateTimeImmutable($value));
    }

    public static function now(): self
    {
        return new self(new DateTimeImmutable());
    }

    public static function distantPast(): self
    {
        return new self(new DateTimeImmutable('0001-01-01 00:00:00'));
    }

    public static function distantFuture(): self
    {
        return new self(new DateTimeImmutable('9999-12-31 23:59:59'));
    }

    public function isBefore(DateTime $other): bool
    {
        return $other->value > $this->value;
    }

    public function isAfter(DateTime $other): bool
    {
        return $other->value < $this->value;
    }

    public function toString(): string
    {
        return $this->value->format('Y-m-d H:i:s');
    }

    public function startOfDay(): self
    {
        return new self($this->value->setTime(0, 0, 0));
    }

    public function endOfDay(): self
    {
        return new self($this->value->setTime(23, 59, 59));
    }

    public function value(): DateTimeImmutable
    {
        return $this->value;
    }

    private function __construct(DateTimeImmutable $value)
    {
        $this->value = $value;
    }
}
