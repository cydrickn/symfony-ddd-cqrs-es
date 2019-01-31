<?php

declare(strict_types = 1);

namespace App\Query\Common;

/**
 * Description of Query
 *
 * @author Cydrick Nonog <cydrick.dev@gmail.com>
 */
class Query
{
    /**
     * @var bool
     */
    private $responseAsArray = false;

    public function setResponseAsArray(): self
    {
        $this->responseAsArray = true;

        return $this;
    }

    public function setResponseAsObject(): self
    {
        $this->responseAsArray = false;

        return $this;
    }

    public function isReturnAsArray(): bool
    {
        return $this->responseAsArray;
    }
}
