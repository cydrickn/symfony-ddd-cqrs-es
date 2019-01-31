<?php

declare(strict_types = 1);

namespace Common\ReadModel;

use Common\Domain\Event\DomainEventInterface;
use Common\Serializer\Serializable;

/**
 *
 * @author Cydrick Nonog <cydrick.dev@gmail.com>
 */
interface ReadModelInterface extends Serializable
{
    public function getId(): string;

    public function apply(DomainEventInterface $event): void;
}
