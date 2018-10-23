<?php

namespace App\Domain;

use EventSauce\EventSourcing\AggregateRootId;
use Ramsey\Uuid\Uuid;

class PlayerProcessId implements AggregateRootId
{
    /**
     * @var \Ramsey\Uuid\Uuid
     */
    private $playerId;

    /**
     * PlayerProcessId constructor.
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
     * @return string
     */
    public function toString(): string
    {
        return $this->playerId->toString();
    }

    /**
     * @param string $aggregateRootId
     *
     * @return static
     */
    public static function fromString(string $aggregateRootId): AggregateRootId
    {
        return new static($aggregateRootId);
    }
}
