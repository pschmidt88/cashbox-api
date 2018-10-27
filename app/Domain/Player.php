<?php

namespace App\Domain;

use App\Domain\Commands\CreatePlayer;
use App\Domain\Commands\ImposeFine;
use App\Domain\Events\FineImposed;
use App\Domain\Events\PlayerWasCreated;
use Illuminate\Support\Collection;
use Prooph\EventSourcing\AggregateChanged;
use Prooph\EventSourcing\AggregateRoot;
use Ramsey\Uuid\Uuid;

class Player extends AggregateRoot
{
    /** @var Uuid $uuid */
    private $uuid;
    /** @var string $firstName */
    private $firstName;
    /** @var string $lastName */
    private $lastName;
    /** @var Collection $fines */
    private $fines;
    /** @var int $balance */
    private $balance;

//    /**
//     *
//     * @param AggregateRootId $id
//     */
//    public function __construct(AggregateRootId $id)
//    {
//        $this->aggregateRootId = $id;
//        $this->fines = new Collection();
//    }

    /**
     * @param string $firstName
     * @param string $lastName
     * @return Player
     * @throws \Exception
     */
    public static function createPlayer(string $firstName, string $lastName): Player
    {
        $uuid = Uuid::uuid4();

        $instance = new self();
        $instance->recordThat(PlayerWasCreated::occur($uuid->toString(),
            ['first_name' => $firstName, 'last_name' => $lastName]));

        return $instance;
    }

    /**
     * @param ImposeFine $command
     * @throws \Exception
     */
    public function imposeFine(ImposeFine $command): void
    {
//        $this->recordThat(
//            new FineImposed($command->offence(), $command->amount(), $command->imposedAt()));
    }

    protected function apply(AggregateChanged $event): void
    {
        switch (get_class($event)) {
            case PlayerWasCreated::class:
                /** @var PlayerWasCreated $event */
                $this->applyPlayerCreated($event);
                break;
            case FineImposed::class:
                /** @var FineImposed $event */
                $this->applyFineImposed($event);
                break;
            default:
                dd("unknown event type");
        }
    }

    public function applyPlayerCreated(PlayerWasCreated $event): void
    {
        $this->uuid = Uuid::fromString($event->aggregateId());
        $this->firstName = $event->getFirstName();
        $this->lastName = $event->getLastName();
    }

    public function applyFineImposed(FineImposed $event): void
    {
//        $fine = new Fine($event->getOffence(), $event->getAmount(), $event->getImposedAt());
//        $this->fines->put($event->getId()->toString(), $fine);
//        $this->addToBalance($event->getAmount());
    }

    /**
     * Array representation of this aggregate
     *
     * @return array
     */
    public function toArray(): array
    {
//        return [
//            'id' => $this->aggregateRootId->toString(),
//            'first_name' => $this->firstName,
//            'last_name' => $this->lastName,
//            'fines' => $this->fines,
//            'balance' => $this->balance
//        ];
        return [];
    }


    protected function aggregateId(): string
    {
        return $this->uuid->toString();
    }
}
