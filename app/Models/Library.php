<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Library extends Model
{
    protected $fillable = [
        'name',
        'description',
        'location',
        'color',
    ];

    public function books()
    {
        return $this->hasMany(\App\Models\Book::class);
    }
}
