<?php

declare(strict_types = 1);

namespace Common\EventSourcing;

use Common\EventStore\EventMessage;
use Common\EventStore\EventMeta;
use Common\EventStore\EventStream;

/**
 * Description of EventSourceTrait
 *
 * @author Cydrick Nonog <cydrick.dev@gmail.com>
 */
trait EventSourceTrait
{
    /**
     * @var array
     */
    private $uncommitedEvents = [];

    /**
     * @var int
     */
    private $playhead = 0;

    public function applyEvent($event): void
    {
        $this->handleEvent($event);

        ++$this->playhead;
        $this->uncommitedEvents[] = EventMessage::recordNow(
            $this->getAggregateRootId(),
            $this->playhead,
            new EventMeta([
                'aggregate_id' => $this->getAggregateRootId(),
            ]),
            $event
        );
    }

    public function getUncommitedEvents(): array
    {
        $uncommitedEvents = $this->uncommitedEvents;
        $this->uncommitedEvents = [];

        return $uncommitedEvents;
    }

    public function initializeState(\Iterator $eventStream): void
    {
        foreach ($eventStream as $message) {
            $this->playhead = $message->getPlayhead();
            $this->handleEvent($message->getPayload());
        }
    }

    public function getPlayhead(): int
    {
        return $this->playhead;
    }

    abstract public function getAggregateRootId(): string;

    private function getHandleEventMethod($event): string
    {
        $classParts = explode('\\', get_class($event));
        $class = end($classParts);
        if (substr($class, -1, 5) !== 'Event') {
            $class .= 'Event';
        }

        return 'apply' . $class;
    }

    private function handleEvent($event): void
    {
        $method = $this->getHandleEventMethod($event);
        if (!method_exists($this, $method)) {
            return;
        }
        $this->$method($event);
    }
}
