<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class furniture extends Model
{
    use HasFactory;

    protected $fillable = ['height', 'width', 'length', 'weight'];


    public function ad()
    {
        return $this->morphOne(Ad::class, 'adable', 'item_type', 'ad_id');
    }
}
