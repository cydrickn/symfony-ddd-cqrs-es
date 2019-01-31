<?php

declare (strict_types = 1);

namespace Common\ReadModel;

/**
 *
 * @author Cydrick Nonog <cydrick.dev@gmail.com>
 */
interface ReadModelRepositoryInterface
{
    public function save(ReadModelInterface $readModel): void;

    public function find(string $id): ?ReadModelInterface;

    public function findAll(): AbstractReadModelIterator;

    public function remove(string $id): void;
}
