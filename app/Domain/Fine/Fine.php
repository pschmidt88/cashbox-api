<?php

namespace App\Domain\Fine;

use EventSauce\EventSourcing\AggregateRoot;
use EventSauce\EventSourcing\AggregateRootBehaviour\AggregateRootBehaviour;
use Illuminate\Support\Carbon;

class Fine implements AggregateRoot
{
    use AggregateRootBehaviour;

    /** @var string */
    private $offence;
    /** @var int */
    private $amount;
    /** @var Carbon */
    private $issuedAt;

    /**
     * Fine constructor.
     * @param $offence
     * @param $amount
     * @param $issuedAt
     */
    public function __construct(string $offence, int $amount, Carbon $issuedAt)
    {
        $this->offence = $offence;
        $this->amount = $amount;
        $this->issuedAt = $issuedAt;
    }

    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray()
    {
        return [
            'offence' => $this->offence,
            'amount' => $this->amount,
            'issued_at' => $this->issuedAt
        ];
    }
}
