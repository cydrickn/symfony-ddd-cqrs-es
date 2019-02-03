<?php

namespace Infra\EventStore;

use Cydrickn\DDD\Common\EventStore\EventMessage;
use Cydrickn\DDD\Common\EventStore\Exceptions\UnableToAppendEventException;
use Cydrickn\DDD\Common\EventStore\StreamName;
use Cydrickn\DDD\Common\EventStore\TransactionalEventStoreInterface;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;
use Infra\Exceptions\UnsupportedTypeException;
use Infra\Iterator\EventMessageIterator;

/**
 * Description of DbalEventStore
 *
 * @author Cydrick Nonog <cydrick.dev@gmail.com>
 */
class DbalEventStore implements TransactionalEventStoreInterface
{
    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function appendEvent(StreamName $streamName, $event): void
    {
        $data = $event;
        if ($data instanceof EventMessage) {
            $data = [
                'id' => $event->id(),
                'aggregate_id' => $event->aggregateId(),
                'aggregate_type' => $event->getMeta()->get('aggregate_type'),
                'metadata' => json_encode($event->getMeta()->toArray()),
                'playhead' => $event->playhead(),
                'payload' => json_encode($event->payload()->serialize()),
                'recorded_on' => $event->recordedOn()->format('Y-m-d H:i:s'),
                'type' => $event->type(),
            ];
        } elseif (!is_array($data)) {
            throw new UnsupportedTypeException('The event has invalid type');
        }

        try {
            $parameters = [];
            $values = [];

            foreach ($data as $key => $value) {
                $parameters[$key] = $value;
                $values[$key] = ':' . $key;
            }
            $queryBuilder = $this
                ->createQueryBuilder()
                ->insert($streamName->toString())
                ->values($values)
                ->setParameters($parameters);

            $this->connection->beginTransaction();
            $queryBuilder->execute();
            $this->connection->commit();
        } catch (\Exception $e) {
            $this->connection->rollBack();
            throw new UnableToAppendEventException($event, 0, $e);
        }
    }

    public function appendEvents(StreamName $streamName, \Iterator $events): void
    {
        try {
            $this->connection->beginTransaction();
            foreach ($events as $event) {
                $this->appendEvent($streamName, $event);
            }
            $this->connection->commit();
        } catch (\Exception $e) {
            $this->connection->rollBack();
        }
    }

    public function hasStream(StreamName $name): bool
    {
        return $this->connection->getSchemaManager()->tablesExist([$name->toString()]);
    }

    public function load(StreamName $streamName, int $playhead = 1, ?int $count = null, array $filters = []): \Iterator
    {
        $queryBuilder = $this
            ->createQueryBuilder($streamName->toString(), 's')
            ->andWhere('s.playhead = :playhead')
            ->orderBy('s.recorded_on', 'ASC')
            ->addOrderBy('s.playhead', 'ASC');

        if ($count !== null) {
            $queryBuilder->setMaxResults($count);
        }

        if (array_has($filters, 'aggregate_id')) {
            $queryBuilder->andWhere('s.aggregate_id = :aggregateId');
            $queryBuilder->setParameter('aggregateId', array_get($filters, 'aggregate_id'));
        }

        if (array_has($filters, 'aggregate_type')) {
            $queryBuilder->andWhere('s.aggregate_type = :aggregate_type');
            $queryBuilder->setParameter('aggregate_type', array_get($filters, 'aggregate_type'));
        }

        return new EventMessageIterator($queryBuilder->execute());
    }

    public function remove(StreamName $streamName, array $filters = []): void
    {
        $queryBuider = $this->createQueryBuilder();
        $queryBuider->delete($streamName->toString());

        foreach ($filters as $key => $value) {
            $queryBuider->andWhere(sprintf('%s = :%s', $key, $key));
            $queryBuider->setParameter($key, $value);
        }

        try {
            $this->connection->beginTransaction();
            $queryBuider->execute();
            $this->connection->commit();
        } catch (Exception $ex) {
            $this->connection->rollBack();
            throw $ex;
        }
    }

    private function createQueryBuilder(?string $tableName = null, ?string $alias = null): QueryBuilder
    {
        $queryBuilder = $this->connection->createQueryBuilder();
        if ($tableName !== null) {
            $queryBuilder->from($tableName, $alias);
        }

        return $queryBuilder;
    }

    public function beginTransaction(): void
    {
        $this->connection->beginTransaction();
    }

    public function commit(): void
    {
        $this->connection->commit();
    }

    public function rollback(): void
    {
        $this->connection->rollBack();
    }
}
