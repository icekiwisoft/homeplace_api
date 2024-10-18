<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class AnnouncerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->name,
            'user' => new UserResource($this->user),
            'id' => $this->id,
            'avatar' => $this->avatar ?   Storage::url($this->avatar) : null,
            'creation_date' => $this->created_at,
            'bio' => $this->bio,
            'verified' => (bool) $this->verified,
            'furnitures' => $this->whenLoaded("furnitures"),

        ];
    }
}
