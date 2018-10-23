<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Player extends JsonResource
{
    /** @var \App\Domain\Player $resource */
    public $resource;

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        /**  */
        return [
            'id' => $this->resource->aggregateRootId()->toString(),
            'first_name' => $this->resource->getFirstName(),
            'last_name' => $this->resource->getLastName(),
            'fines' => $this->when(
                $this->resource->getFines()->isNotEmpty(),
                $this->resource->getFines()),
            'balance' => $this->when($this->resource->getBalance() > 0,
                $this->resource->getBalance(),
                0),
        ];
    }
}
