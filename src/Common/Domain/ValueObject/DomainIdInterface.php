<?php

declare(strict_types = 1);

namespace Common\Domain\ValueObject;

/**
 *
 * @author Cydrick Nonog <cydrick.dev@gmail.com>
 */
interface DomainIdInterface
{
    public static function fromString(string $id): self;

    public function isEmpty(): bool;

    public function equals(self $id): bool;

    public function toString(): string;

    public function __toString(): string;
}
