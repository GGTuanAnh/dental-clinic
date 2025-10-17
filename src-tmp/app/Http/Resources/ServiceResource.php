<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ServiceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'price' => $this->price,
            'duration_minutes' => $this->duration_minutes ?? null,
            'image_url' => $this->image ? asset('storage/' . $this->image) : null,
            'description' => $this->description ?? null,
        ];
    }
}
