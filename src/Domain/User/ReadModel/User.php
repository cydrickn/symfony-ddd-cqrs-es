<?php

declare(strict_types = 1);

namespace Domain\User\ReadModel;

use Cydrickn\DDD\Common\ReadModel\AbstractReadModel;
use Cydrickn\DDD\Common\Serializer\Serializable;
use Domain\User\Event\UserWasCreated;
use Domain\User\UserId;
use Domain\User\Username;

/**
 * Description of User
 *
 * @author Cydrick Nonog <cydrick.dev@gmail.com>
 */
class User extends AbstractReadModel
{
    /**
     * @var UserId
     */
    private $id;

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

    public static function deserialize(array $data): Serializable
    {
        $instance = new static;
        $instance->id = UserId::fromString($data['id']);
        $instance->username = new Username($data['username']);
        $instance->password = $data['password'];
        $instance->createdAt = \DateTimeImmutable::createFromFormat(
            'Y-m-d H:i:s',
            $data['created_at'],
            new \DateTimeZone('UTC')
        );

        return $instance;
    }

    public function serialize(): array
    {
        return [
            'id' => $this->id->toString(),
            'username' => $this->username->toString(),
            'password' => $this->password,
            'created_at' => $this->createdAt->format('Y-m-d H:i:s'),
        ];
    }

    public function getId(): string
    {
        return $this->id->toString();
    }

    public function getUserId(): UserId
    {
        return $this->id;
    }

    public function getUsername(): Username
    {
        return $this->username;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function applyUserWasCreated(UserWasCreated $event): void
    {
        $this->username = $event->username();
        $this->password = $event->password();
        $this->id = $event->id();
        $this->createdAt = $event->createdAt();
    }
}
