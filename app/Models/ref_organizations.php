<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ref_organizations extends Model
{
    protected $table = 'ref_organizations';

    protected $fillable = [
        'organization_code', 'organization_desc',
    ];
}
