<?php

declare(strict_types = 1);

namespace Common\EventStore\Exceptions;

/**
 * Description of UnableToAppendEventException
 *
 * @author Cydrick Nonog <cydrick.dev@gmail.com>
 */
class UnableToAppendEventException extends \RuntimeException
{
    private $event;

    public function __construct($event, int $code = 0, \Throwable $previous = NULL)
    {
        parent::__construct('Unable to save event', $code, $previous);

        $this->event = $event;
    }
}
