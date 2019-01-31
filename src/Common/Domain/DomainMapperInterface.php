<?php

declare(strict_types = 1);

namespace Common\Domain;

/**
 *
 * @author Cydrick Nonog <cydrick.dev@gmail.com>
 */
interface DomainMapperInterface
{
    public function fetchById(ValueObject\DomainIdInterface $id): DomainInterface;

    public function fetchAll(array $criterias = []): DomainCollectionInterface;
}
