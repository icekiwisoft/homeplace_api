<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Announcer extends Model
{
    use HasFactory;



    public $incrementing = false;
    protected $fillable = [
        'name',
        'phone_number',
        'email'
    ];

    public function ads(): HasMany
    {

        return $this->hasMany(Ad::class);
    }


    public function medias(): HasMany
    {

        return $this->hasMany(Media::class);
    }
}
