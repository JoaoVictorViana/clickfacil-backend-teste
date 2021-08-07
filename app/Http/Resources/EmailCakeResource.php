<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EmailCakeResource extends JsonResource
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
            'email_interested_cake_id' => $this->email_interested_cake_id,
            'cake_id_fk' => $this->cake_id_fk,
            'email' => $this->email,
        ];
    }
}
