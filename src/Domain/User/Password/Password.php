<?php

declare(strict_types = 1);

namespace Domain\User\Password;

/**
 * Description of Password
 *
 * @author Cydrick Nonog <cydrick.dev@gmail.com>
 */
final class Password implements PasswordInterface
{
    /**
     * @var PasswordEncoderInterface
     */
    private $encoder;

    /**
     * @var string
     */
    private $encodedPassword;

    public static function encode(string $plainPassword, PasswordEncoderInterface $encoder): PasswordInterface
    {
        return new static($encoder->encode($plainPassword), $encoder);
    }

    public static function fromEncodedString(string $hash, PasswordEncoderInterface $encoder): PasswordInterface
    {
        return new static($hash, $encoder);
    }

    public function match(string $plainPassword): bool
    {
        return $this->encoder->match($plainPassword, $this->encodedPassword);
    }

    public function toString(): string
    {
        return $this->encodedPassword;
    }

    public function __toString(): string
    {
        return $this->encodedPassword;
    }

    private function __construct(string $encodedPassword, PasswordEncoderInterface $encoder)
    {
        $this->encodedPassword = $encodedPassword;
        $this->encoder = $encoder;
    }
}
