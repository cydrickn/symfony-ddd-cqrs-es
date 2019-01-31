<?php

declare(strict_types = 1);

namespace UI\Http\Api\Request;

use Symfony\Component\HttpFoundation\Request;

/**
 * Description of GetUserRequest
 *
 * @author Cydrick Nonog <cydrick.dev@gmail.com>
 */
class GetUserRequest
{
    private $id;

    public static function createFromRequest(Request $request): self
    {
        $instance = new GetUserRequest();
        $instance->id = $request->get('id');

        return $instance;
    }

    public function id(): string
    {
        return $this->id;
    }
}
