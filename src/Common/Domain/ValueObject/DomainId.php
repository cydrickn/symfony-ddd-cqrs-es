<?php

declare(strict_types = 1);

namespace Common\Domain\ValueObject;

/**
 * Description of DomainId
 *
 * @author Cydrick Nonog <cydrick.dev@gmail.com>
 */
class DomainId implements DomainIdInterface
{
    /**
     * @var string
     */
    private $id;

    final public static function fromString(string $id): DomainIdInterface
    {
        return new static($id);
    }

    final public function equals(DomainIdInterface $id): bool
    {
        return $id === $this
            ? true
            : (
                $this->id !== null&& $id instanceof self && static::class === \get_class($id)
                ? $this->id === $id->id
                : false
            );
    }

    final public function isEmpty(): bool
    {
        return $this->id === null || $this->id === '';
    }

    final public function toString(): string
    {
        return $this->id;
    }

    final public function __toString(): string
    {
        return $this->id;
    }

    final public function __construct(string $id = null)
    {
        $this->id = $id;
    }
}
