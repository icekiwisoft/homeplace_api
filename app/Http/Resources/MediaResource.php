<?php

namespace App\Http\Resources;

use App\Models\Announcer;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;


class MediaResource extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id"=>$this->id,
            "file"=>$this->file,
            "thumbnail"=>$this->thumbnail,
            "type"=>$this->type,
            "announcer"=>new AnnouncerResource($this->announcer),
            "ads_number"=>$this->ads()->count()
        ];
    }
}
