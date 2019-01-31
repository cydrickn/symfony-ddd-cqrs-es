<?php

declare(strict_types = 1);

namespace Common\EventStore;

/**
 *
 * @author Cydrick Nonog <cydrick.dev@gmail.com>
 */
interface EventStoreInterface
{
    public function hasStream(StreamName $name): bool;

    public function load(StreamName $streamName, int $playhead = 1, ?int $count = null, array $filters = []): \Iterator;

    public function appendEvents(StreamName $streamName, \Iterator $events): void;

    public function appendEvent(StreamName $streamName, $event): void;

    public function remove(StreamName $streamName, array $filters = []): void;
}
