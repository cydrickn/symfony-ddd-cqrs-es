<?php

declare(strict_types = 1);

namespace Common\Domain;

use Common\Domain\ValueObject\DomainIdInterface;

/**
 *
 * @author Cydrick Nonog <cydrick.dev@gmail.com>
 */
interface DomainInterface
{
    public function id(): ?DomainIdInterface;
}
