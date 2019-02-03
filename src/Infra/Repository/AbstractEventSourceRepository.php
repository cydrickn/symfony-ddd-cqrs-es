<?php

declare(strict_types = 1);

namespace Infra\Repository;

use Cydrickn\DDD\Common\EventSourcing\EventSourcedRepositoryInterface;
use Cydrickn\DDD\Common\EventSourcing\EventSourceInterface;
use Cydrickn\DDD\Common\EventSourcing\Exceptions\ClassIsNotEventSourcedException;
use Cydrickn\DDD\Common\EventStore\EventMessage;
use Cydrickn\DDD\Common\EventStore\EventStoreInterface;
use Cydrickn\DDD\Common\EventStore\StreamName;
use Cydrickn\DDD\Common\EventStore\TransactionalEventStoreInterface;
use Infra\DataSource\EventStore\EventStore;
use Symfony\Component\Messenger\MessageBusInterface;

/**
 * Description of AbstractRepository
 *
 * @author Cydrick Nonog <cydrick.dev@gmail.com>
 */
abstract class AbstractEventSourceRepository implements EventSourcedRepositoryInterface
{
    /**
     * @var TransactionalEventStoreInterface
     */
    private $eventStore;

    /**
     * @var MessageBusInterface
     */
    private $domainEventBus;

    public function __construct(TransactionalEventStoreInterface $eventStore, MessageBusInterface $domainEventBus)
    {
        $this->eventStore = $eventStore;
        $this->domainEventBus = $domainEventBus;
    }

    public function sourceExists(string $id): bool
    {
        $event = $this->eventStore->load(
            $this->getStreamName(),
            1,
            1,
            ['aggregate_id' => $id, 'aggregate_type' => $this->getAggregateType()]
        );

        return $event->valid();
    }

    public function getSource(string $id): EventSourceInterface
    {
        $events = $this->eventStore->load(
            $this->getStreamName(),
            1,
            null,
            ['aggregate_id' => $id, 'aggregate_type' => $this->getAggregateType()]
        );

        $class = $this->getAggregateClass();
        $aggregate = new $class;
        if (!($aggregate instanceof EventSourceInterface)) {
            throw new ClassIsNotEventSourcedException(sprintf(
                '%s must implement %s',
                $class,
                EventSourceInterface::class
            ));
        }

        $aggregate->initializeState($events);

        return $aggregate;
    }

    public function saveSource(EventSourceInterface $eventSourced): void
    {
        try {
            $this->eventStore->beginTransaction();
            $this->saveSourceEvents(new \ArrayIterator($eventSourced->getUncommitedEvents()));
            $this->eventStore->commit();
        } catch (Exception $ex) {
            $this->eventStore->rollback();
            throw $ex;
        }
    }

    public function saveSourceEvents(\Iterator $events): void
    {
        try {
            $this->eventStore->beginTransaction();
            foreach ($events as $event) {
                $this->saveSourceEvent($event->withAddedMetadata('aggregate_type', $this->getAggregateType()));
            }
            $this->eventStore->commit();
        } catch (\Exception $e) {
            $this->eventStore->rollback();
            throw $e;
        }
    }

    public function saveSourceEvent(EventMessage $event): void
    {
        try {
            $this->eventStore->beginTransaction();
            $this->domainEventBus->dispatch($event);
            $this->eventStore->appendEvent($this->getStreamName(), $event);
            $this->eventStore->commit();
        } catch (\Exception $e) {
            $this->eventStore->rollback();
            throw $e;
        }
    }

    protected function getStreamName(): StreamName
    {
        return new StreamName('event_store');
    }

    abstract protected function getAggregateType(): string;

    abstract protected function getAggregateClass(): string;
}
