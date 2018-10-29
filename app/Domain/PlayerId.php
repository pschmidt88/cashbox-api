<?php

namespace App\Domain;

use Ramsey\Uuid\Uuid;

final class PlayerId
{
    /**
     * @var Uuid
     */
    private $playerId;

    /**
     * PlayerId constructor.
     *
     * @param string $aggregateRootId
     */
    protected function __construct(string $aggregateRootId)
    {
        if (!Uuid::isValid($aggregateRootId)) {
            throw new \InvalidArgumentException("The provided id is not a valid UUID. Given: $aggregateRootId");
        }

        $this->playerId = Uuid::fromString($aggregateRootId);
    }

    /**
     * @return PlayerId
     * @throws \Exception
     */
    public static function create(): PlayerId
    {
        return new static(Uuid::uuid4()->toString());
    }

    /**
     * @return string
     */
    public function toString(): string
    {
        return $this->playerId->toString();
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toString();
    }


    /**
     * @param string $aggregateRootId
     *
     * @return static
     */
    public static function fromString(string $aggregateRootId): PlayerId
    {
        return new static($aggregateRootId);
    }
}
