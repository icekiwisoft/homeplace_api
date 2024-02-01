<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Ramsey\Uuid\Uuid;

class Ad extends Model
{
    protected $keyType = 'string';
    use HasFactory , HasUuids;

    public function newUniqueId(): string
    {
        return (string) Uuid::uuid4();
    }
    protected $fillable = [
        'price',
        'description',
        'mainroom',
        'toilet',
        'kitchen',
        'mainroom',
        'item_type',
        'height',
        'width',
        'length',
        'weight'
    ];

    public function announcer(): BelongsTo
    {
        return $this->belongsTo(Announcer::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function medias(): BelongsToMany
    {
        return $this->belongsToMany(Media::class);
    }
}
