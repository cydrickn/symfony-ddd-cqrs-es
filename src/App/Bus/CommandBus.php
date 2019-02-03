<?php

namespace App\Bus;

use Cydrickn\DDD\Common\Command\CommandBusInterface;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;

/**
 * Description of CommandBus
 *
 * @author Cydrick Nonog <cydrick.dev@gmail.com>
 */
class CommandBus implements CommandBusInterface
{
    use HandleTrait {
        handle as traitHandle;
    }

    public function __construct(MessageBusInterface $commandBus)
    {
        $this->messageBus = $commandBus;
    }

    public function handle($message): void
    {
        $this->traitHandle($message);
    }
}
