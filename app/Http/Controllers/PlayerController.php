<?php

namespace App\Http\Controllers;

use App\Domain\Commands\CreatePlayer;
use App\Domain\Commands\ImposeFine;
use App\Domain\Player;
use App\Domain\PlayerProcessId;
use App\Http\Resources\Player as PlayerResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

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
     * @return JsonResource
     * @throws \Exception
     */
    public function createPlayer(Request $request): JsonResource
    {
        $validated = $request->validate([
            'first_name' => 'required',
            'last_name' => 'required'
        ]);

        $player = Player::createPlayer(new CreatePlayer($validated['first_name'], $validated['last_name']));

        $this->repository->persist($player);

        return JsonResource::make($player);
    }

    /**
     * @param string $id
     * @param Request $request
     * @return JsonResource
     * @throws \Exception
     */
    public function addFine(string $id, Request $request): JsonResource
    {
        $playerId = PlayerProcessId::fromString($id);
        /** @var Player $player */
        $player = $this->repository->retrieve($playerId);

        $validated = $request->validate([
            'offence' => 'required',
            'amount' => 'required|integer',
            'imposed_at' => 'required|date'
        ]);

        $player->imposeFine(new ImposeFine($validated['offence'],
                                           $validated['amount'],
                                           Carbon::parse($validated['imposed_at'])));

        $this->repository->persist($player);

        return PlayerResource::make($player);
    }

    public function findById($id): JsonResource
    {
        $playerId = PlayerProcessId::fromString($id);
        $playerProcess = $this->repository->retrieve($playerId);

        return PlayerResource::make($playerProcess);
    }
}
