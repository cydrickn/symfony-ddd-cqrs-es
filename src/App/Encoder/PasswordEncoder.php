<?php

declare(strict_types = 1);

namespace App\Encoder;

use Domain\User\Password\PasswordEncoderInterface;

/**
 * Description of PasswordEncoder
 *
 * @author Cydrick Nonog <cydrick.dev@gmail.com>
 */
class PasswordEncoder implements PasswordEncoderInterface
{
    private const COST = 12;

    public function encode(string $plainPassword): string
    {
        return password_hash($plainPassword, PASSWORD_BCRYPT, ['cost' => self::COST]);
    }

    public function match(string $plainPassword, string $encodedPassword): string
    {
        return password_verify($plainPassword, $encodedPassword);
    }
}
