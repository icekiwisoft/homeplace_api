<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RealEstate extends Model
{
    use HasFactory;
    protected $fillable = ['toilet', 'kitchen', 'bedroom', 'mainroom'];


    public function ad()
    {
        return $this->morphOne(Ad::class, 'adable', 'item_type', 'ad_id');
    }
}
