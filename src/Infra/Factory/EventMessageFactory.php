<?php

namespace Infra\Factory;

use Cydrickn\DDD\Common\EventStore\EventMessage;
use Infra\DataSource\EventStore\EventStoreRecord;

/**
 * Description of EventMessageFactory
 *
 * @author Cydrick Nonog <cydrick.dev@gmail.com>
 */
class EventMessageFactory
{
    public static function createMessageFromArray(EventStoreRecord $record): EventMessage
    {
        $class = strtr(get_class($record->type), '.', '\\');
        $message = new EventMessage(
            $record->id,
            $record->aggregate_id,
            $record->playhead,
            new \Common\EventStore\EventMeta($record->metadata),
            $class::deserialize($record->playhead),
            \DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $record->recorded_on, new \DateTimeZone('UTC'))
        );

        return $message;
    }
}
