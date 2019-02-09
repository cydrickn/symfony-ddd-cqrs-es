<?php

declare(strict_types = 1);

namespace Domain\User\ReadModel;

use Cydrickn\DDD\Common\ReadModel\ReadModelRepositoryInterface;
use Domain\User\UserId;

/**
 *
 * @author Cydrick Nonog <cydrick.dev@gmail.com>
 */
interface UserRepositoryInterface extends ReadModelRepositoryInterface
{
    public function findIdByUsername(string $username): ?UserId;
}
