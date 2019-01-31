<?php

namespace UI\Http\Api\Request;

use Symfony\Component\HttpFoundation\Request;

/**
 * Description of CreateUserRequest
 *
 * @author Cydrick Nonog <cydrick.dev@gmail.com>
 */
class CreateUserRequest
{
    private $username;

    private $password;

    public static function createFromRequest(Request $request): self
    {
        $data = array_merge_recursive($request->request->all(), json_decode($request->getContent(), true));

        $instance = new static;
        $instance->username = $data['username'];
        $instance->password = $data['password'];

        return $instance;
    }

    public function username(): string
    {
        return $this->username;
    }

    public function password(): string
    {
        return $this->password;
    }
}
