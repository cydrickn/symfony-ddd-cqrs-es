<?php

declare(strict_types = 1);

namespace Domain\User\Event;

use Common\Domain\Event\DomainEventInterface;
use Common\Serializer\Serializable;
use Domain\User\Password\Password;
use Domain\User\Password\PasswordInterface;
use Domain\User\UserId;
use Domain\User\Username;

/**
 * Description of UserWasCreated
 *
 * @author Cydrick Nonog <cydrick.dev@gmail.com>
 */
final class UserWasCreated implements DomainEventInterface
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
     * @var PasswordInterface
     */
    private $password;

    /**
     * @var \DateTimeImmutable
     */
    private $createdAt;

    public function id(): UserId
    {
        return $this->id;
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

    public function __construct(UserId $id, Username $username, string $password, \DateTimeImmutable $createdAt)
    {
        $this->id = $id;
        $this->username = $username;
        $this->password = $password;
        $this->createdAt = $createdAt;
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

    public static function deserialize(array $data): Serializable
    {
        return new static(
            UserId::fromString($data['id']),
            new Username($data['id']),
            $data['password'],
            \DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $data['created_at'], new \DateTimeZone('UTC'))
        );
    }
}
