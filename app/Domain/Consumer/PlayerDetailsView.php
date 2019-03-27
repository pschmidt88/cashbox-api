<?php

namespace App\Domain\Consumer;

use App\Domain\Player\Events\PlayerCreated;
use App\Domain\Player\PlayerId;
use Carbon\Carbon;
use EventSauce\EventSourcing\Consumer;
use EventSauce\EventSourcing\Header;
use EventSauce\EventSourcing\Message;
use EventSauce\EventSourcing\MessageRepository;
use Illuminate\Contracts\Support\Arrayable;

/**
 */
class PlayerDetailsView implements Consumer, Arrayable
{
    /**
     * @var MessageRepository
     */
    private $messageRepository;
    private $id;
    private $registeredAt;
    private $firstName;
    private $lastName;

    /**
     * PlayerDetailsView constructor.
     *
     * @param MessageRepository $messageRepository
     */
    public function __construct(MessageRepository $messageRepository)
    {
        $this->messageRepository = $messageRepository;
    }

    public function getById(PlayerId $playerId)
    {
        foreach ($this->messageRepository->retrieveAll($playerId) as $message) {
            $this->handle($message);
        }
    }

    public function handle(Message $message)
    {
        if ($message->event() instanceof PlayerCreated) {
            $this->id = $message->aggregateRootId()->toString();
            $this->registeredAt = Carbon::parse($message->header(Header::TIME_OF_RECORDING));
            $this->firstName = $message->event()->getFirstName();
            $this->lastName = $message->event()->getLastName();
        }
    }

    public function toArray()
    {
        return [
            'id' => $this->id,
            'first_name' => $this->firstName,
            'last_name' => $this->lastName
        ];
    }
}
