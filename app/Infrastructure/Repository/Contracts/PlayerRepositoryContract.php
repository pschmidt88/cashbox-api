<?php

namespace App\Infrastructure\Repository\Contracts;

use App\Domain\Player;
use Ramsey\Uuid\Uuid;

interface PlayerRepositoryContract
{
    public function save(Player $player): void;

    public function get(Uuid $uuid): ?Player;
}
