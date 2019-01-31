<?php

declare(strict_types = 1);

namespace Common\Domain\ValueObject;

/**
 * Description of String
 *
 * @author Cydrick Nonog <cydrick.dev@gmail.com>
 */
class StringObject
{
    private $value;

    public function isEmpty(): bool
    {
        return empty($this->value);
    }

    public function equals(StringObject $string): bool
    {
        return $this === $string ? true : $string->value === $this->id;
    }

    public function toString(): string
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return $this->value;
    }

    public function __construct(string $value)
    {
        $this->value = $value;
    }
}
