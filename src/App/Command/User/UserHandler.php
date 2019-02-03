<?php

declare(strict_types = 1);

namespace App\Command\User;

use App\Command\User\CreateUser;
use Cydrickn\DDD\Common\Command\AbstractCommandHandler;
use Domain\User\Password\Password;
use Domain\User\Password\PasswordEncoderInterface;
use Domain\User\Repository\UserRepositoryInterface;
use Domain\User\Service\UserService;
use Domain\User\Username;
use Symfony\Component\Messenger\Handler\MessageSubscriberInterface;

/**
 * Description of UserHandler
 *
 * @author Cydrick Nonog <cydrick.dev@gmail.com>
 */
class UserHandler extends AbstractCommandHandler implements MessageSubscriberInterface
{
    /**
     * @var UserRepositoryInterface
     */
    private $userRepository;

    /**
     * @var PasswordEncoderInterface
     */
    private $passwordEncoder;

    /**
     * @var UserService
     */
    private $userService;

    public static function getHandledMessages(): iterable
    {
        yield CreateUser::class;
    }

    public function __construct(
        UserRepositoryInterface $userRepository,
        PasswordEncoderInterface $passwordEncoder,
        UserService $userService
    ) {
        $this->userRepository = $userRepository;
        $this->passwordEncoder = $passwordEncoder;
        $this->userService = $userService;
    }

    protected function handleCreateUser(CreateUser $command): void
    {
        $user = $this->userService->createUser(
            $command->userId(),
            new Username($command->username()),
            Password::encode($command->plainPassword(), $this->passwordEncoder)->toString()
        );

        $this->userRepository->store($user);
    }
}
