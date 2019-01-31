<?php

namespace Infra\Iterator;

use Doctrine\DBAL\Driver\ResultStatement;
use Doctrine\DBAL\FetchMode;

/**
 * Description of ReadModelIterator
 *
 * @author Cydrick Nonog <cydrick.dev@gmail.com>
 */
class DBALReadModelIterator extends \Common\ReadModel\AbstractReadModelIterator
{
    /**
     * @var ResultStatement
     */
    private $resultStatement;

    /**
     * @var string
     */
    private $readModelClass;

    /**
     * @var bool
     */
    private $rewinded = false;

    /**
     * @var int
     */
    private $key = -1;

    /**
     * @var mixed
     */
    private $current = null;

    public function __construct(string $readModelClass, ResultStatement $resultStatement)
    {
        $this->readModelClass = $readModelClass;
        $this->resultStatement = $resultStatement;
    }

    public function current()
    {
        return $this->current;
    }

    public function key(): \scalar
    {
        return $this->key;
    }

    public function next()
    {
        $class = $this->readModelClass;

        $result = $this->resultStatement->fetch(FetchMode::ASSOCIATIVE);

        if ($result === false) {
            $this->current = false;
        } elseif ($this->returnAsArray) {
            $this->current = $result;
        } else {
            $this->current = $class::deserialize($result);
        }

        $this->key++;

        return $this->current;
    }

    public function rewind(): void
    {
        if ($this->rewinded == true) {
            throw new \LogicException("Can only iterate a Result once.");
        } else {
            $this->current = $this->next();
            $this->rewinded = true;
        }
    }

    public function valid(): bool
    {
        return ($this->current != false);
    }
}
