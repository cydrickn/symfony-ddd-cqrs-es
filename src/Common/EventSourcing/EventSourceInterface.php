<?php

declare(strict_types = 1);

namespace Common\EventSourcing;

use Common\EventStore\EventStream;

/**
 *
 * @author Cydrick Nonog <cydrick.dev@gmail.com>
 */
interface EventSourceInterface
{
    public function getUncommitedEvents(): array;

    public function getAggregateRootId(): string;

    public function initializeState(\Iterator $events): void;

    public function getPlayhead(): int;
}
