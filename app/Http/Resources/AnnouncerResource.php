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
            'email'=> $this->email,
            'contact'=> $this->phone_number,
            'id'=>$this->id,
            'avatar'=>$this->avatar?   Storage::url($this->avatar):null,
            'creation_date'=>$this->created_at,
            'bio'=>$this->bio,
            'verified'=>$this->verified,
            'furnitures'=>$this->whenLoaded("furnitures"),

        ];
    }
}
