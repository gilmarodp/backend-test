<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RedirectLogResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'ip_address' => $this->ip_address,
            'user_agent' => $this->user_agent,
            'header_refer' => $this->header_refer,
            'query_params' => $this->query_params ? json_decode($this->query_params) : [],
            'accessed_at' => $this->accessed_at,
        ];
    }
}
