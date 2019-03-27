<?php

namespace App\Infrastructure\Repository;

use EventSauce\EventSourcing\AggregateRootId;
use EventSauce\EventSourcing\Header;
use EventSauce\EventSourcing\Message;
use EventSauce\EventSourcing\MessageRepository;
use EventSauce\EventSourcing\Serialization\MessageSerializer;
use Generator;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;

class DatabaseMessageRepository implements MessageRepository
{
    const TABLE_NAME = 'event_stream';

    /** @var MessageSerializer $messageSerializer */
    private $messageSerializer;

    /**
     *
     * @param MessageSerializer $messageSerializer
     */
    public function __construct(MessageSerializer $messageSerializer)
    {
        $this->messageSerializer = $messageSerializer;
    }

    public function persist(Message ...$messages)
    {
        if (count($messages) === 0) {
            return;
        }

        $insert = [];
        foreach ($messages as $message) {
            $insert[] = [
                'event_id' => $message->header(Header::EVENT_ID) ?? Uuid::uuid4()->toString(),
                'created_at' => Carbon::parse($message->header(Header::TIME_OF_RECORDING)),
                'event_type' => $message->header(Header::EVENT_TYPE),
                'aggregate_root_id' => $message->header(Header::AGGREGATE_ROOT_ID)->toString(),
                'payload' => json_encode($this->serializedMessage($message), JSON_PRETTY_PRINT),
            ];
        }

        app('db')->table(self::TABLE_NAME)->insert($insert);
    }

    public function retrieveAll(AggregateRootId $id): Generator
    {
        $messages = app('db')->table(self::TABLE_NAME)
            ->where('aggregate_root_id', $id->toString())
            ->orderBy('created_at', 'asc')
            ->get(['payload']);

        foreach ($messages as $message) {
            yield from $this->messageSerializer->unserializePayload(json_decode($message->payload, true));
        }
    }

    private function serializedMessage($message): array
    {
        return $this->messageSerializer->serializeMessage($message);
    }
}
