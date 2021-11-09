<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'id', 'name', 'price', 'description', 'created_at', 'updated_at'
    ];

    protected $hidden = [
    ];
}
