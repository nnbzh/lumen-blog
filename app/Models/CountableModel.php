<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CountableModel extends Model
{
    public $timestamps = false;

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    protected $fillable = [
        'post_id',
        'count'
    ];
}