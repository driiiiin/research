<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use OwenIt\Auditing\Auditable;

class ref_nuhra extends Model
{
    protected $table = 'ref_nuhra';

    protected $fillable = [
        'nuhra_code', 'nuhra_desc',
    ];
}
