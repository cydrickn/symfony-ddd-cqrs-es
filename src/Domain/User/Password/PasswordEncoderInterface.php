<?php

declare(strict_types = 1);

namespace Domain\User\Password;

/**
 *
 * @author Cydrick Nonog <cydrick.dev@gmail.com>
 */
interface PasswordEncoderInterface
{
    public function encode(string $plainPassword): string;

    public function match(string $plainPassword, string $encodedPassword): string;
}
