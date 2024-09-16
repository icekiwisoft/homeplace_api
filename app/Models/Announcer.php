<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Announcer extends Model
{
    use HasFactory;
    public $incrementing = false;
    protected $fillable = [
        'name',
        'user_id'
    ];

    public function ads(): HasMany
    {

        return $this->hasMany(Ad::class);
    }


    public function medias(): HasMany
    {

        return $this->hasMany(Media::class);
    }

    public function user(): HasOne
    {
        return $this->hasOne(User::class);
    }
}
