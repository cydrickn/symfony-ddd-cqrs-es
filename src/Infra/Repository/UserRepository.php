<?php

namespace Infra\Repository;

use Common\EventStore\EventStoreInterface;
use Domain\User\Repository\UserRepositoryInterface;
use Domain\User\User;
use Domain\User\UserId;

/**
 * Description of UserRepository
 *
 * @author Cydrick Nonog <cydrick.dev@gmail.com>
 */
class UserRepository extends AbstractEventSourceRepository implements UserRepositoryInterface
{
    public function exists(UserId $id): bool
    {
        return $this->sourceExists($id->toString());
    }

    public function get(UserId $id): User
    {
        return $this->getSource($id->toString());
    }

    public function store(User $user): void
    {
        $this->saveSource($user);
    }

    protected function getAggregateClass(): string
    {
        return User::class;
    }

    protected function getAggregateType(): string
    {
        return 'user';
    }
}
