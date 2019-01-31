<?php

declare(strict_types = 1);

namespace Common\EventStore;

use Common\Serializer\Serializable;
use Ramsey\Uuid\Uuid;

/**
 * Description of Event
 *
 * @author Cydrick Nonog <cydrick.dev@gmail.com>
 */
class EventMessage
{
    private $id;

    private $aggregateId;

    private $playhead;

    private $meta;

    private $payload;

    private $recordedOn;

    public static function recordNow(string $aggregateId, int $playhead, EventMeta $meta, $payload): self
    {
        $uuid = Uuid::uuid4()->toString();

        return new static(
            $uuid,
            $aggregateId,
            $playhead,
            $meta,
            $payload,
            new \DateTimeImmutable('now', new \DateTimeZone('UTC'))
        );
    }

    public function __construct(string $id, string $aggregateId, int $playhead, EventMeta $meta, $payload, \DateTimeImmutable $recordedOn)
    {
        $this->id = $id;
        $this->aggregateId = $aggregateId;
        $this->playhead = $playhead;
        $this->payload = $payload;
        $this->meta = $meta;
        $this->recordedOn = $recordedOn;
    }

    public function aggregateId(): string
    {
        return $this->aggregateId;
    }

    public function getMeta(): EventMeta
    {
        return $this->meta;
    }

    public function id(): string
    {
        return $this->id;
    }

    public function playhead(): int
    {
        return $this->playhead;
    }

    public function payload(): Serializable
    {
        return $this->payload;
    }

    public function recordedOn(): \DateTimeImmutable
    {
        return $this->recordedOn;
    }

    public function type(): string
    {
        return strtr(get_class($this->payload), '\\', '.');
    }

    public function withAddedMetadata(string $key, $value): self
    {
        return new static(
            $this->id,
            $this->aggregateId,
            $this->playhead,
            $this->meta->set($key, $value),
            $this->payload,
            $this->recordedOn
        );
    }
}
