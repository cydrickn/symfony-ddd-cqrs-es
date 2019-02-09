<?php

declare(strict_types = 1);

namespace Domain\Common\Password;

/**
 *
 * @author Cydrick Nonog <cydrick.dev@gmail.com>
 */
interface PasswordEncoderInterface
{
    public function encode(string $plainPassword): string;

    public function match(string $plainPassword, string $encodedPassword): bool;
}
