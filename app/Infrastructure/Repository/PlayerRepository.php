<?php

namespace App\Infrastructure\Repository;

use App\Domain\Player;
use App\Infrastructure\Repository\Contracts\PlayerRepositoryContract;
use Prooph\EventSourcing\Aggregate\AggregateRepository;
use Prooph\EventSourcing\Aggregate\AggregateType;
use Prooph\EventSourcing\EventStoreIntegration\AggregateTranslator;
use Prooph\EventStore\EventStore;
use Ramsey\Uuid\Uuid;

class PlayerRepository extends AggregateRepository implements PlayerRepositoryContract
{
    /**
     * PlayerRepository constructor.
     *
     * @param EventStore $eventStore
     */
    public function __construct(EventStore $eventStore)
    {
        parent::__construct($eventStore,
            AggregateType::fromAggregateRootClass(Player::class),
            new AggregateTranslator(),
            null, null, true);
    }

    public function save(Player $player): void
    {
        $this->saveAggregateRoot($player);
    }

    /**
     * @param Uuid $uuid
     * @return Player|null
     */
    public function get(Uuid $uuid): ?Player
    {
        return $this->getAggregateRoot($uuid->toString());
    }
}
