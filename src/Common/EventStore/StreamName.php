<?php

declare(strict_types = 1);

namespace Common\EventStore;

/**
 * Description of StreamName
 *
 * @author Cydrick Nonog <cydrick.dev@gmail.com>
 */
class StreamName
{
    /**
     * @var string
     */
    private $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function toString(): string
    {
        return $this->name;
    }

    public function __toString(): string
    {
        return $this->name;
    }
}
