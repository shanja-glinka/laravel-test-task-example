<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * @param mixed $request
     * 
     * @return array
     */
    public function toArray($request): array
    {
       return [
           'id' => $this->id,
           'name' => $this->name,
           'email' => $this->email,
           'ip' => $this->ip,
           'comment' => $this->comment,
           'created_at' => $this->created_at->toDateTimeString(),
           'updated_at' => $this->updated_at->toDateTimeString()
       ];
    }
}
