<?php

namespace App\Observers;

use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;

class MediaObserver
{
    /**
     * Handle the Media "created" event.
     */
    public function creating(Media $media): void
    {


        // Log::error($media->file);
        //     $thumbnail = Image::read($media->file)->scale(500)->save(public_path('storage\\thumbnails\\' ."vtt"));
        $media->thumbnail = $media->file;
    }
}
