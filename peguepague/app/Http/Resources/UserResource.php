<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'document_type' => $this->document_type->description,
            'document' => $this->document,
            'user_type' => $this->user_type->description,
            'wallet' => new WalletResource($this->wallet)
        ];
    }
}
