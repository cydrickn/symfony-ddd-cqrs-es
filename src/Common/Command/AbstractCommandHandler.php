<?php

declare(strict_types = 1);

namespace Common\Command;

/**
 * Description of AbstractCommandHandler
 *
 * @author Cydrick Nonog <cydrick.dev@gmail.com>
 */
abstract class AbstractCommandHandler implements CommandHandlerInterface
{
    public function __invoke($command): void
    {
        $method = $this->getHandleMethod($command);
        if (!method_exists($this, $method)) {
            return;
        }
        $this->$method($command);
    }

    private function getHandleMethod($command): string
    {
        $classParts = explode('\\', get_class($command));

        return 'handle'.end($classParts);
    }
}
