<?php

namespace App\Http\Controllers;

use App\Domain\Consumer\PlayerDetailsView;
use App\Domain\Player\Commands\CreatePlayer;
use App\Domain\Player\Player;
use App\Domain\Player\PlayerId;
use EventSauce\EventSourcing\AggregateRootRepository;
use EventSauce\EventSourcing\ConstructingAggregateRootRepository;
use EventSauce\EventSourcing\MessageDispatcher;
use EventSauce\EventSourcing\MessageRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use PHPUnit\Util\Json;

class PlayerController extends Controller
{
    /** @var AggregateRootRepository $repository */
    private $repository;

    /**
     * PlayerController constructor.
     */
    public function __construct()
    {
        $this->repository = new ConstructingAggregateRootRepository(
            Player::class,
            app()->make(MessageRepository::class),
            app()->make(MessageDispatcher::class)
        );
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws \Exception
     */
    public function createPlayer(Request $request): JsonResponse
    {
        $validated = $this->validate($request, [
            'first_name' => 'required',
            'last_name' => 'required'
        ]);

        $player = Player::createPlayer(new CreatePlayer($validated['first_name'], $validated['last_name']));
        $this->repository->persist($player);

        $playerDetails = app(PlayerDetailsView::class);
        $playerDetails->getById($player->aggregateRootId());

        return new JsonResponse($playerDetails);
    }

    public function findById($id): JsonResponse
    {
        $playerId = PlayerId::fromString($id);

        /** @var Player $player */
        $player = $this->repository->retrieve($playerId);

        if (!$player->exists()) {
            return new JsonResponse(['error' => 'not found'], 404);
        }

        return new JsonResponse([
            'id' => $player->aggregateRootId()->toString(),
            'first_name' => $player->getFirstName(),
            'last_name' => $player->getLastName(),
        ]);
    }
}
