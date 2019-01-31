<?php

declare(strict_types = 1);

namespace App\Query\User;

use App\Query\Common\Query;

/**
 * Description of GetUser
 *
 * @author Cydrick Nonog <cydrick.dev@gmail.com>
 */
class GetUser extends Query
{
    private $userId;

    public function __construct(string $userId)
    {
        $this->userId = $userId;
    }

    public function userId(): string
    {
        return $this->userId;
    }
}
