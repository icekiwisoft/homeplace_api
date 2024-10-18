<?php

namespace App\Http\Resources;

use App\Models\furniture;
use App\Models\RealEstate;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class Adresource extends  JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {

        return [
            'id' => $this->id,
            'type' => $this->item_type,
            'description' => $this->description,
            'price' => $this->price,
            'medias' => $this->medias()->count(),
            'category' => new CategoryResource($this->category),
            $this->mergeWhen($this->item_type == RealEstate::class, [
                'mainroom' => $this->adable->mainroom,
                'toilet' => $this->adable->toilet,
                'kitchen' => $this->adable->kitchen,
                'mainroom' => $this->adable->mainroom,
            ]),

            $this->mergeWhen($this->item_type == furniture::class, [
                'height' => $this->adable->height,
                'width' => $this->adable->width,
                'length' => $this->adable->length,
                'weight' => $this->adable->weight,
            ]),
            "announcer" => new AnnouncerResource($this->announcer),
            'creation_date' => $this->created_at,
            'liked' => false
        ];
    }
}
