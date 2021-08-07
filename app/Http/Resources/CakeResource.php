<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CakeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'cake_id' => $this->cake_id,
            'name' => $this->name,
            'weight' => $this->weight,
            'price' => $this->price,
            'quantity' => $this->quantity,
            'emails' => EmailCakeResource::collection($this->emails),
        ];
    }
}
