<?php

declare(strict_types = 1);

namespace Domain\Common\Password;

/**
 *
 * @author Cydrick Nonog <cydrick.dev@gmail.com>
 */
interface PasswordInterface
{
    public static function encode(string $plainPassword, PasswordEncoderInterface $encoder): self;

    public static function fromEncodedString(string $hash, PasswordEncoderInterface $encoder): self;

    public function match(string $plainPassword): bool;

    public function toString(): string;

    public function __toString(): string;
}
