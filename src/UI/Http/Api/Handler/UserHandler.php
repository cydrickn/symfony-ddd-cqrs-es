<?php

declare(strict_types = 1);

namespace UI\Http\Api\Handler;

use App\Bus\CommandBus;
use App\Bus\QueryBus;
use App\Command\User\CreateUser;
use App\Query\User\GetAllUser;
use App\Query\User\GetUser;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Domain\User\Exceptions\UserIdDoesNotExistsException;
use Domain\User\Exceptions\UsernameAlreadyExistsException;
use Domain\User\UserId;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Messenger\Handler\MessageSubscriberInterface;
use UI\Http\Api\Request\CreateUserRequest;
use UI\Http\Api\Request\GetAllUserRequest;
use UI\Http\Api\Request\GetUserRequest;

/**
 * Description of CreateUserHandler
 *
 * @author Cydrick Nonog <cydrick.dev@gmail.com>
 */
class UserHandler extends AbstractHandler implements MessageSubscriberInterface
{
    /**
     * @var CommandBus
     */
    private $commandBus;

    /**
     * @var QueryBus
     */
    private $queryBus;

    /**
     * @var LoggerInterface
     */
    private $logger;

    public static function getHandledMessages(): iterable
    {
        yield CreateUserRequest::class;
        yield GetUserRequest::class;
        yield GetAllUserRequest::class;
    }

    public function __construct(CommandBus $commandBus, QueryBus $queryBus, LoggerInterface $logger)
    {
        $this->commandBus = $commandBus;
        $this->queryBus = $queryBus;
        $this->logger = $logger;
    }

    public function handleCreateUserRequest(CreateUserRequest $request): JsonResponse
    {
        $userId = UserId::generate();

        $httpCode = JsonResponse::HTTP_CREATED;
        $result = [];

        try {
            $command = new CreateUser($userId, $request->username(), $request->password());
            $this->commandBus->handle($command);

            $query = new GetUser($userId->toString());
            $query->setResponseAsArray();
            $result = $this->queryBus->handle($query);
            array_forget($result, 'password');
        } catch (UniqueConstraintViolationException $ex) {
            $result = ['message' => 'The user is not unique', 'errors' => []];
            $httpCode = JsonResponse::HTTP_UNPROCESSABLE_ENTITY;
            $this->logger->error($ex->getMessage(), ['exception' => $ex]);
        } catch (UsernameAlreadyExistsException $ex) {
            $result = ['message' => 'Invalid Request', 'errors' => ['username' => $ex->getMessage()]];
            $httpCode = JsonResponse::HTTP_UNPROCESSABLE_ENTITY;
        }

        return new JsonResponse($result, $httpCode);
    }

    public function handleGetUserRequest(GetUserRequest $request): JsonResponse
    {
        $userId = $request->id();

        $query = new GetUser($userId);
        $query->setResponseAsArray();

        try {
            $result = $this->queryBus->handle($query);
            array_forget($result, 'password');

            return new JsonResponse($result);
        } catch (UserIdDoesNotExistsException $ex) {
            return new JsonResponse(['message' => $ex->getMessage()], JsonResponse::HTTP_NOT_FOUND);
        }
    }

    public function handleGetAllUserRequest(GetAllUserRequest $request): JsonResponse
    {
        $query = new GetAllUser();
        $query->setResponseAsArray();

        $result = array_map(function ($user) {
            array_forget($user, 'password');

            return $user;
        }, $this->queryBus->handle($query));

        return new JsonResponse($result);
    }
}
