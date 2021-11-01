<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends TimestampedModel
{
    use HasFactory;

    protected $table = 'categories';

    protected $fillable = [
        'slug',
        'name'
    ];
}