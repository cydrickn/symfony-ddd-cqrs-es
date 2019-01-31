<?php

declare(strict_types = 1);

namespace Domain\User\Repository;

use Domain\User\User;
use Domain\User\UserId;

/**
 *
 * @author Cydrick Nonog <cydrick.dev@gmail.com>
 */
interface UserRepositoryInterface
{
    public function get(UserId $id): User;

    public function store(User $user): void;

    public function exists(UserId $id): bool;
}
