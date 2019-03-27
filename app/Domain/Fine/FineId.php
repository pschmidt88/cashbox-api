<?php

namespace App\Domain\Fine;

use EventSauce\EventSourcing\AggregateRootId;
use Ramsey\Uuid\Uuid;

class FineId implements AggregateRootId
{
    /**
     * @var Uuid $id
     */
    private $id;

    /**
     *
     * @param string $aggregateRootId
     */
    protected function __construct(string $aggregateRootId)
    {
        if (!Uuid::isValid($aggregateRootId)) {
            throw new \InvalidArgumentException("The provided string is not a valid UUID. Given: $aggregateRootId");
        }

        $this->id = Uuid::fromString($aggregateRootId);
    }

    /**
     * @return string
     */
    public function toString(): string
    {
        return $this->id->toString();
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
