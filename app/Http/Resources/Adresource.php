<?php

namespace App\Http\Resources;

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
            'medias'=>$this->medias()->count(),
            'category'=>new CategoryResource($this->category),
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
            "presentation"=>$this->presentation_img?   Storage::url($this->presentation_img):null,
            "announcer" => new AnnouncerResource($this->announcer),
            'creation_date'=>$this->created_at,
            'liked'=>false



        ];
    }
}
