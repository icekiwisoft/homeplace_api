<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomeCategory extends Model
{
    protected $table = "homecategories";
    use HasFactory;
    protected $fillable = [
        'name'
    ];
}
