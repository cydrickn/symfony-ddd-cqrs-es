<?php

declare(strict_types = 1);

namespace App\Query\User;

use Cydrickn\DDD\Common\Query\AbstractQueryHandler;
use Domain\User\Exceptions\UserIdDoesNotExistsException;
use Domain\User\ReadModel\UserRepositoryInterface;
use Symfony\Component\Messenger\Handler\MessageSubscriberInterface;

/**
 * Description of UserHandler
 *
 * @author Cydrick Nonog <cydrick.dev@gmail.com>
 */
class UserHandler extends AbstractQueryHandler implements MessageSubscriberInterface
{
    /**
     * @var UserRepositoryInterface
     */
    private $userRepository;

    public static function getHandledMessages(): iterable
    {
        yield GetUser::class;
        yield GetAllUser::class;
    }

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    protected function handleGetUser(GetUser $command)
    {
        $result = $this->userRepository->find($command->userId());

        if ($result === null) {
            throw new UserIdDoesNotExistsException(sprintf('User id "%s" does not exists', $command->userId()));
        }

        if ($command->isReturnAsArray()) {
            return $result->serialize();
        }

        return $result;
    }

    protected function handleGetAllUser(GetAllUser $command): array
    {
        $iterator = $this->userRepository->findAll();

        if ($command->isReturnAsArray()) {
            $iterator->setReturnAsArray();
        }

        $result = [];
        foreach ($iterator as $data) {
            $result[] = $data;
        }

        return $result;
    }
}
