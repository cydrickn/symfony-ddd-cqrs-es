<?php

declare(strict_types = 1);

namespace Domain\User\ReadModel;

use Common\EventStore\EventMessage;
use Common\ReadModel\AbstractReadModelEventHandler;
use Domain\User\Event\UserWasCreated;

/**
 * Description of UserProjector
 *
 * @author Cydrick Nonog <cydrick.dev@gmail.com>
 */
class UserEventSubscriber extends AbstractReadModelEventHandler
{
    /**
     * @var UserRepositoryInterface
     */
    private $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function handleUserWasCreated(EventMessage $message): void
    {
        $user = new User();
        $user->apply($message->payload());

        $this->userRepository->save($user);
    }

    public static function supports(EventMessage $event): bool
    {
        $supportedClases = [
            UserWasCreated::class,
        ];

        return in_array(get_class($event->payload()), $supportedClases);
    }
}
