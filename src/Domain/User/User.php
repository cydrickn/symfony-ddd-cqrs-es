<?php

declare(strict_types = 1);

namespace Domain\User;

use Common\Domain\AbstractDomain;
use Common\EventSourcing\EventSourceInterface;
use Common\EventSourcing\EventSourceTrait;
use Domain\User\Password\PasswordInterface;

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
            throw new Exceptions\InvalidIdException('Id cannot be blank');
        }

        return $this->id()->toString();
    }

    protected function applyUserWasCreatedEvent(Event\UserWasCreated $event): void
    {
        $this->id = $event->id();
        $this->username = $event->username();
        $this->password = $event->password();
        $this->createdAt = $event->createdAt();
    }
}
