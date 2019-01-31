<?php

declare(strict_types = 1);

namespace UI\Http\Api\Handler;

/**
 * Description of AbstractHandler
 *
 * @author Cydrick Nonog <cydrick.dev@gmail.com>
 */
abstract class AbstractHandler
{
    public function __invoke($request)
    {
        $method = $this->getHandleMethod($request);
        if (!method_exists($this, $method)) {
            return;
        }
        return $this->$method($request);
    }

    private function getHandleMethod($request): string
    {
        $classParts = explode('\\', get_class($request));

        return 'handle'.end($classParts);
    }
}
