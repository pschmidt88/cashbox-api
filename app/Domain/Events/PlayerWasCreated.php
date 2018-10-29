<?php

namespace App\Domain\Events;

use App\Domain\PlayerId;
use Prooph\EventSourcing\AggregateChanged;

class PlayerWasCreated extends AggregateChanged
{
//    /** @var \Ramsey\Uuid\UuidInterface $id */
//    private $id;
//    /** @var string */
//    private $firstName;
//    /** @var string */
//    private $lastName;
//
//    /**
//     * PlayerCreated constructor.
//     * @param string $firstName
//     * @param string $lastName
//     * @throws \Exception
//     */
//    public function __construct(string $firstName, string $lastName)
//    {
//        $this->id = Uuid::uuid4();
//        $this->firstName = $firstName;
//        $this->lastName = $lastName;
//    }
//
//    public function toPayload(): array
//    {
//        return [
//            'first_name' => $this->firstName,
//            'last_name' => $this->lastName,
//        ];
//    }
//
//    /**
//     * @param array $payload
//     * @return SerializableEvent
//     * @throws \Exception
//     */
//    public static function fromPayload(array $payload): SerializableEvent
//    {
//        return new static($payload['first_name'], $payload['last_name']);
//    }
//
//    /**
//     * @return \Ramsey\Uuid\UuidInterface
//     */
//    public function getId(): \Ramsey\Uuid\UuidInterface
//    {
//        return $this->id;
//    }

    /**
     * @return PlayerId
     */
    public function getPlayerId(): PlayerId
    {
        return PlayerId::fromString($this->aggregateId());
    }

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->payload['first_name'];
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->payload['last_name'];
    }
}
