<?php

namespace Psr\Uuid;

interface UuidGeneratorInterface
{
    /**
     * Creates a new UUID.
     *
     * @return string A UUID string that adheres to the UUID specification.
     */
    public function create(): string;
}
