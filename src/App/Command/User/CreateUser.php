<?php

declare(strict_types = 1);

namespace App\Command\User;

use Common\Command\CommandInterface;
use Domain\User\UserId;

/**
 * Description of CreateUser
 *
 * @author Cydrick Nonog <cydrick.dev@gmail.com>
 */
class CreateUser
{
    private $userId;

    private $username;

    private $password;

    public function __construct(UserId $userId, string $username, string $plainPassword)
    {
        $this->username = $username;
        $this->userId = $userId;
        $this->password = $plainPassword;
    }

    public function userId(): UserId
    {
        return $this->userId;
    }

    public function username(): string
    {
        return $this->username;
    }

    public function plainPassword(): string
    {
        return $this->password;
    }
}
