<?php

declare(strict_types = 1);

namespace Common\Domain;

/**
 *
 * @author Cydrick Nonog <cydrick.dev@gmail.com>
 */
interface DomainCollectionInterface extends \Countable, \ArrayAccess, \IteratorAggregate
{
    public function add($user): void;

    public function remove($user): void;

    public function removeById($id): void;

    public function get($id);

    public function exists($id): bool;

    public function clear(): void;

    public function toArray(): array;
}
