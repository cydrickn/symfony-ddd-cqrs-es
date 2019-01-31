<?php

declare(strict_types = 1);

namespace Common\EventStore;

/**
 * Description of EventMeta
 *
 * @author Cydrick Nonog <cydrick.dev@gmail.com>
 */
class EventMeta
{
    private $data;

    public function __construct(array $data = [])
    {
        $this->data = $data;
    }

    public function get(string $key, $default = null)
    {
        return $this->data[$key] ?? $default;
    }

    public function has(string $key): bool
    {
        return array_key_exists($key, $this->data);
    }

    public function set(string $key, $value): self
    {
        $instance = new EventMeta($this->data);
        $instance->setMutable($key, $value);

        return $instance;
    }

    public function setMutable(string $key, $value): self
    {
        $this->data[$key] = $value;

        return $this;
    }

    public function toArray(): array
    {
        return $this->data;
    }
}
