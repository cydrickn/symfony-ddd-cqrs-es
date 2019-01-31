<?php

declare(strict_types = 1);

namespace Common\Command;

/**
 *
 * @author Cydrick Nonog <cydrick.dev@gmail.com>
 */
interface CommandHandlerInterface
{
    public function __invoke($command): void;
}
