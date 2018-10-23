<?php

namespace App\Domain\Consumer;

use EventSauce\EventSourcing\Consumer;
use EventSauce\EventSourcing\Message;

class PlayerDetailsView implements Consumer
{
    public function handle(Message $message)
    {
    }
}
