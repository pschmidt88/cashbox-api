<?php

namespace Tests\Feature;

use Laravel\Lumen\Testing\DatabaseTransactions;
use Ramsey\Uuid\Uuid;
use Tests\TestCase;

class CreatePlayerTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @test
     */
    public function user_can_create_a_new_player()
    {
        $playerId = Uuid::uuid4()->toString();

        $response = $this->json('PUT',
            "/api/player/$playerId",
            ['first_name' => 'Paul', 'last_name' => 'Schmidt']);

        $response
            ->seeStatusCode(200)
            ->seeJson(['first_name' => 'Paul', 'last_name' => 'Schmidt']);
    }
}
