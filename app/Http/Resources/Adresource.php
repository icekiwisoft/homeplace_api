<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

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
            'medias'=>MediaResource::collection($this->medias),
            $this->mergeWhen($this->item_type == 0, [
                'mainroom' => $this->mainroom,
                'toilet' => $this->toilet,
                'kitchen' => $this->kitchen,
                'mainroom' => $this->mainroom,
            ]),

            $this->mergeWhen($this->item_type == 1, [
                'height' => $this->height,
                'width' => $this->width,
                'length' => $this->length,
                'weight' => $this->weight,
            ]),
            "announcer" => new AnnouncerResource($this->announcer)
        ];
    }
}
