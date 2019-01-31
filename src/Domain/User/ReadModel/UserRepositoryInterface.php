<?php

declare(strict_types = 1);

namespace Domain\User\ReadModel;

use Common\ReadModel\ReadModelRepositoryInterface;

/**
 *
 * @author Cydrick Nonog <cydrick.dev@gmail.com>
 */
interface UserRepositoryInterface extends ReadModelRepositoryInterface
{
    public function findIdByUsername(string $username): ?\Domain\User\UserId;
}
