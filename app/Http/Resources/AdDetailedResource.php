<?php

namespace App\Http\Resources;

use App\Models\furniture;
use App\Models\RealEstate;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AdDetailedResource extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    private function getType($item)
    {
        if ($item ==  RealEstate::class) {
            return "realestate";
        }
        if ($item ==  furniture::class) {
            return "furniture";
        }
    }
    public function toArray(Request $request): array
    {

        return [
            'id' => (int) $this->id,
            'type' => $this->getType($this->item_type),
            'description' => $this->description,
            'price' => $this->price,
            'medias' => $this->medias()->count(),
            'ad_type' => $this->ad_type,
            'period' => $this->period,
            'devise' => $this->devise,
            'category' => new CategoryResource($this->category),
            $this->mergeWhen($this->item_type == RealEstate::class, [
                'mainroom' => $this->adable->mainroom,
                'toilet' => $this->adable->toilet,
                'kitchen' => $this->adable->kitchen,
                'mainroom' => $this->adable->mainroom,
                'garden' => $this->adable->garden,
                'gate' => $this->adable->gate,
                'pool' => $this->adable->pool,
                'caution' => $this->adable->caution,

            ]),

            $this->mergeWhen($this->item_type == furniture::class, [
                'height' => $this->adable->height,
                'width' => $this->adable->width,
                'length' => $this->adable->length,
                'weight' => $this->adable->weight,
            ]),
            "announcer" => new AnnouncerResource($this->announcer),
            'creation_date' => $this->created_at,
            'liked' => true
        ];
    }
}
