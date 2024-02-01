<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\MediaLibrary\MediaCollections\Models\Concerns\HasUuid;

class Media extends Model
{
    use HasFactory,HasUuids;
    protected $uploadedFile;
    protected $fillable = [
        'file',
        'description',
        'announcer_id'
    ];

    public function ads(): BelongsToMany
    {
        return $this->belongsToMany(ad::class);
    }

    public function announcer(): BelongsTo
    {
        return $this->belongsTo(Announcer::class);
    }
}
