<?php

namespace App\Observers;

use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;

class MediaObserver
{
    /**
     * Handle the Media "created" event.
     */
    public function creating(Media $media): void
    {
        if(!is_string($media->file))
        {
            $mimetype = $media->file->getMimeType();
            $filename = date("d_m_y") . "---" . $media->file->hashName();
            $savedfile = $media->file->storeAs('public/images', $filename);


            $media->file = Storage::url($savedfile);

            $thumbnail = Image::read(('storage/images/' . $filename))->scale(300, 300)->save(public_path('storage\\thumbnails\\' . $filename));
            $media->thumbnail = Storage::url('public/thumbnails/' . $filename);
            $media->type = $mimetype;
        }
    }


}
