<?php

namespace App\Bus;

use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;

/**
 * Description of CommandBus
 *
 * @author Cydrick Nonog <cydrick.dev@gmail.com>
 */
class CommandBus
{
    use HandleTrait {
        handle as traitHandle;
    }

    public function __construct(MessageBusInterface $commandBus)
    {
        $this->messageBus = $commandBus;
    }

    public function handle($message)
    {
        return $this->traitHandle($message);
    }
}
