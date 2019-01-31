<?php

namespace UI\Http\Bus;

use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;

/**
 * Description of CommandBus
 *
 * @author Cydrick Nonog <cydrick.dev@gmail.com>
 */
class RequestBus
{
    use HandleTrait {
        handle as traitHandle;
    }

    public function __construct(MessageBusInterface $requestBus)
    {
        $this->messageBus = $requestBus;
    }

    public function handle($message)
    {
        return $this->traitHandle($message);
    }
}
