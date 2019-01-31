<?php

namespace App\Bus;

use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;

/**
 * Description of CommandBus
 *
 * @author Cydrick Nonog <cydrick.dev@gmail.com>
 */
class QueryBus
{
    use HandleTrait {
        handle as traitHandle;
    }

    public function __construct(MessageBusInterface $queryBus)
    {
        $this->messageBus = $queryBus;
    }

    public function handle($message)
    {
        return $this->traitHandle($message);
    }
}
