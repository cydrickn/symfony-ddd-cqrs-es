<?php

declare(strict_types = 1);

namespace Common\ReadModel;

/**
 * Description of AbstractReadModelIterator
 *
 * @author Cydrick Nonog <cydrick.dev@gmail.com>
 */
abstract class AbstractReadModelIterator implements \Iterator
{
    protected $returnAsArray = false;

    public function setReturnAsArray(): self
    {
        $this->returnAsArray = true;

        return $this;
    }

    public function setReturnAsObject(): self
    {
        $this->returnAsArray = false;

        return $this;
    }
}
