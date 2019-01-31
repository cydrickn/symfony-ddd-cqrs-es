<?php

namespace UI\Http\Api\Request;

/**
 * Description of GetAllUserRequest
 *
 * @author Cydrick Nonog <cydrick.dev@gmail.com>
 */
class GetAllUserRequest
{
    public static function createFromRequest(\Symfony\Component\HttpFoundation\Request $request): self
    {
        return new static;
    }
}
