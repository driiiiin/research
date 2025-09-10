<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ref_sdgs extends Model
{
    protected $table = 'ref_sdgs';

    protected $fillable = [
        'sdg_code', 'sdg_desc',
    ];
}
