<?php

declare(strict_types = 1);

namespace Domain\User;

use Cydrickn\DDD\Common\Domain\AbstractDomain;
use Cydrickn\DDD\Common\EventSourcing\EventSourceInterface;
use Cydrickn\DDD\Common\EventSourcing\EventSourceTrait;
use Domain\User\Event\UserWasCreated;
use Domain\User\Exceptions\InvalidIdException;

/**
 * Description of Account
 *
 * @author Cydrick Nonog <cydrick.dev@gmail.com>
 */
final class User extends AbstractDomain implements EventSourceInterface
{
    use EventSourceTrait;

    /**
     * @var Username
     */
    private $username;

    /**
     * @var string
     */
    private $password;

    /**
     * @var \DateTimeImmutable
     */
    private $createdAt;

    public function getAggregateRootId(): string
    {
        if ($this->isEmptyId()) {
            throw new InvalidIdException('Id cannot be blank');
        }

        return $this->id()->toString();
    }

    protected function applyUserWasCreatedEvent(UserWasCreated $event): void
    {
        $this->id = $event->id();
        $this->username = $event->username();
        $this->password = $event->password();
        $this->createdAt = $event->createdAt();
    }

    public function username(): Username
    {
        return $this->username;
    }

    public function password(): string
    {
        return $this->password;
    }

    public function createdAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }
}
