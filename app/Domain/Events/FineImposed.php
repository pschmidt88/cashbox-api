<?php

namespace App\Domain\Events;

use Illuminate\Support\Carbon;
use Prooph\EventSourcing\AggregateChanged;
use Ramsey\Uuid\Uuid;

class FineImposed extends AggregateChanged
{
//    /** @var \Ramsey\Uuid\UuidInterface $id */
//    private $id;
//    /** @var string $offence */
//    private $offence;
//    /** @var int $amount */
//    private $amount;
//    /** @var \Illuminate\Support\Carbon $imposedAt */
//    private $imposedAt;
//
//    /**
//     * FineImposed constructor.
//     *
//     * @param string $offence
//     * @param int $amount
//     * @param Carbon $imposedAt
//     * @throws \Exception
//     */
//    public function __construct(string $offence, int $amount, Carbon $imposedAt)
//    {
//        $this->id = Uuid::uuid4();
//        $this->amount = $amount;
//        $this->offence = $offence;
//        $this->imposedAt = $imposedAt;
//    }
//
//    public function toPayload(): array
//    {
//        return [
//            'offence' => $this->offence,
//            'amount' => $this->amount,
//            'imposed_at' => $this->imposedAt->toDateString(),
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
//        return new static($payload['offence'], $payload['amount'], Carbon::parse($payload['imposed_at']));
//    }
//
//    /**
//     * @return \Ramsey\Uuid\UuidInterface
//     */
//    public function getId(): \Ramsey\Uuid\UuidInterface
//    {
//        return $this->id;
//    }
//
//    /**
//     * @return string
//     */
//    public function getOffence(): string
//    {
//        return $this->offence;
//    }
//
//    /**
//     * @return int
//     */
//    public function getAmount(): int
//    {
//        return $this->amount;
//    }
//
//    /**
//     * @return Carbon
//     */
//    public function getImposedAt(): Carbon
//    {
//        return $this->imposedAt;
//    }
}
