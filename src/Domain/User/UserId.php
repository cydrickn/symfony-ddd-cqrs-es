<?php

declare(strict_types = 1);

namespace Domain\User;

use Cydrickn\DDD\Common\Domain\ValueObject\DomainId;
use Ramsey\Uuid\Uuid;

/**
 * Description of UserId
 *
 * @author Cydrick Nonog <cydrick.dev@gmail.com>
 */
class UserId extends DomainId
{
    final public static function generate(): self
    {
        return self::fromString(Uuid::uuid4()->toString());
    }
}
