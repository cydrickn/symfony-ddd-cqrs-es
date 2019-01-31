<?php

declare(strict_types = 1);

namespace Common\Query;

/**
 * Description of AbstractCommandHandler
 *
 * @author Cydrick Nonog <cydrick.dev@gmail.com>
 */
abstract class AbstractQueryHandler implements QueryHandlerInterface
{
    public function __invoke($query)
    {
        $method = $this->getHandleMethod($query);
        if (!method_exists($this, $method)) {
            return;
        }
        return $this->$method($query);
    }

    private function getHandleMethod($query): string
    {
        $classParts = explode('\\', get_class($query));

        return 'handle'.end($classParts);
    }
}
