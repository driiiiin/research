<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ref_sgds extends Model
{
    protected $table = 'ref_sgds';

    protected $fillable = [
        'sgd_code', 'sgd_desc',
    ];
}
