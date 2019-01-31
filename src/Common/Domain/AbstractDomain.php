<?php

declare(strict_types = 1);

namespace Common\Domain;

use Common\Domain\ValueObject\DomainIdInterface;

/**
 * Description of AbstractDomain
 *
 * @author Cydrick Nonog <cydrick.dev@gmail.com>
 */
abstract class AbstractDomain implements DomainInterface
{
    /**
     * @var DomainIdInterface
     */
    protected $id;

    public function id(): ?DomainIdInterface
    {
        return $this->id;
    }

    public function isEmptyId(): bool
    {
        return $this->id === null || ($this->id instanceof DomainIdInterface && $this->id->toString() === '');
    }
}
