<?php

namespace App\Infrastructure;

use EventSauce\EventSourcing\AggregateRoot;
use Illuminate\Contracts\Support\Arrayable;

interface ArrayableAggregateRoot extends AggregateRoot, Arrayable
{
}
