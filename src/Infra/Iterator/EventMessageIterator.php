<?php

declare(strict_types = 1);

namespace Infra\Iterator;

use Atlas\Mapper\RecordSet;
use Infra\Factory\EventMessageFactory;

/**
 * Description of EventMessageIterator
 *
 * @author Cydrick Nonog <cydrick.dev@gmail.com>
 */
class EventMessageIterator implements \Iterator
{
    /**
     * @var \ArrayIterator
     */
    private $innerIterator;

    public function __construct(\Traversable $traversable)
    {
        $this->innerIterator = $traversable;
    }

    public function current()
    {
        $current = $this->innerIterator->current();

        return EventMessageFactory::createMessageFromArray($current);
    }

    public function key(): \scalar
    {
        return $this->innerIterator->key();
    }

    public function next(): void
    {
        $this->innerIterator->next();
    }

    public function rewind(): void
    {
        $this->innerIterator->rewind();
    }

    public function valid(): bool
    {
        return $this->innerIterator->valid();
    }
}
