<?php

namespace App\Domain\Commands;

use Illuminate\Support\Carbon;

final class ImposeFine
{
    /** @var string $offence */
    private $offence;
    /** @var int $amount */
    private $amount;
    /** @var Carbon $imposedAt */
    private $imposedAt;

    /**
     * ImposeFine constructor.
     *
     * @param string $offence
     * @param int $amount
     * @param Carbon $imposedAt
     */
    public function __construct(string $offence, int $amount, Carbon $imposedAt)
    {
        $this->offence = $offence;
        $this->amount = $amount;
        $this->imposedAt = $imposedAt;
    }

    /**
     * @return string
     */
    public function offence(): string
    {
        return $this->offence;
    }

    /**
     * @return int
     */
    public function amount(): int
    {
        return $this->amount;
    }

    /**
     * @return Carbon
     */
    public function imposedAt(): Carbon
    {
        return $this->imposedAt;
    }


}
