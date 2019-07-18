<?php
declare(strict_types=1);

namespace Ngmy\TicketPrice\Domain\Type\Enum;

use BadMethodCallException;
use InvalidArgumentException;

trait EnumTrait
{
    /**
     * @var mixed
     */
    private $scalar;

    final public function __construct($value)
    {
        if (!self::isValidValue($value)) {
            throw new InvalidArgumentException("不正な値です。(値='$value')");
        }

        $this->scalar = $value;
    }

    final public static function isValidValue($value): bool
    {
        return in_array($value, self::ENUM, true);
    }

    final public static function isValidName(string $name): bool
    {
        return array_key_exists($name, self::ENUM);
    }

    final public static function __callStatic(string $name, array $args)
    {
        if (!self::isValidName($name)) {
            throw new BadMethodCallException("不正な名前です。 (名前='{$name}')");
        }

        return new self(self::ENUM[$name]);
    }

    final public function __toString(): string
    {
        return (string) $this->scalar;
    }

    final public function value()
    {
        return $this->scalar;
    }

    final public function __set(string $name, $value): void
    {
        throw new BadMethodCallException('全てのセッターは禁止されています。');
    }
}
