<?php

namespace Common\Serializer;

/**
 *
 * @author Cydrick Nonog <cydrick.dev@gmail.com>
 */
interface Serializable
{
    public static function deserialize(array $data): self;

    public function serialize(): array;
}
