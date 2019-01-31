<?php

declare(strict_types = 1);

namespace Domain\User\Service;

use Domain\User\Event\UserWasCreated;
use Domain\User\Exceptions\UsernameAlreadyExistsException;
use Domain\User\ReadModel\UserRepositoryInterface;
use Domain\User\User;
use Domain\User\UserId;
use Domain\User\Username;

/**
 * Description of UserFactory
 *
 * @author Cydrick Nonog <cydrick.dev@gmail.com>
 */
class UserService
{
    private $userReadModelRepository;

    public function __construct(UserRepositoryInterface $userReadModelRepository)
    {
        $this->userReadModelRepository = $userReadModelRepository;
    }

    public function createUser(UserId $userId, Username $username, string $encodedPassword): User
    {
        if ($this->userReadModelRepository->findIdByUsername($username->toString()) !== null) {
            throw new UsernameAlreadyExistsException(sprintf('Username %s already exists', $username->toString()));
        }

        $event = new UserWasCreated(
            $userId,
            $username,
            $encodedPassword,
            new \DateTimeImmutable('now', new \DateTimeZone('UTC'))
        );

        $user = new User();
        $user->applyEvent($event);

        return $user;
    }
}
