<?php

declare(strict_types = 1);

namespace Common\EventStore;

/**
 * Description of Stream
 *
 * @author Cydrick Nonog <cydrick.dev@gmail.com>
 */
class Stream
{
    /**
     * @var StreamName
     */
    private $name;

    /**
     * @var Iterator
     */
    private $events;

    public function __construct(StreamName $name, \Iterator $events)
    {
        $this->name = $name;
        $this->events = $events;
    }

    public function name(): StreamName
    {
        return $this->name;
    }

    public function events(): \Iterator
    {
        return $this->events;
    }
}
