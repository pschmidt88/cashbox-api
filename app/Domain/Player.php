<?php

namespace App\Domain;

use App\Domain\Commands\CreatePlayer;
use App\Domain\Commands\ImposeFine;
use App\Domain\Events\FineImposed;
use App\Domain\Events\PlayerCreated;
use App\Infrastructure\ArrayableAggregateRoot;
use EventSauce\EventSourcing\AggregateRootBehaviour\AggregateRootBehaviour;
use EventSauce\EventSourcing\AggregateRootId;
use Illuminate\Support\Collection;
use Ramsey\Uuid\Uuid;

class Player implements ArrayableAggregateRoot
{
    use AggregateRootBehaviour;

    /** @var string $firstName */
    private $firstName;
    /** @var string $lastName */
    private $lastName;
    /** @var Collection $fines */
    private $fines;
    /** @var int $balance */
    private $balance;

    /**
     *
     * @param AggregateRootId $id
     */
    private function __construct(AggregateRootId $id)
    {
        $this->aggregateRootId = $id;
        $this->fines = new Collection();
    }

    /**
     * @param CreatePlayer $command
     * @return Player
     * @throws \Exception
     */
    public static function createPlayer(CreatePlayer $command): Player
    {
        $instance = new static(PlayerProcessId::fromString(Uuid::uuid4()->toString()));
        $instance->recordThat(
            new PlayerCreated($command->firstName(), $command->lastName()));

        return $instance;
    }

    /**
     * @param ImposeFine $command
     * @throws \Exception
     */
    public function imposeFine(ImposeFine $command): void
    {
        $this->recordThat(
            new FineImposed($command->offence(), $command->amount(), $command->imposedAt()));
    }

    public function applyPlayerCreated(PlayerCreated $event): void
    {
        $this->firstName = $event->toPayload()['first_name'];
        $this->lastName = $event->toPayload()['last_name'];
    }

    public function applyFineImposed(FineImposed $event): void
    {
        $fine = new Fine($event->getOffence(), $event->getAmount(), $event->getImposedAt());
        $this->fines->put($event->getId()->toString(), $fine);
        $this->addToBalance($event->getAmount());
    }

    /**
     * Array representation of this aggregate
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            'id' => $this->aggregateRootId->toString(),
            'first_name' => $this->firstName,
            'last_name' => $this->lastName,
            'fines' => $this->fines,
            'balance' => $this->balance
        ];
    }

    private function addToBalance(int $amount)
    {
        $this->balance += $amount;
    }
}
