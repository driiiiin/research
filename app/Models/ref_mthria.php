<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use OwenIt\Auditing\Auditable;

class ref_mthria extends Model
{

    protected $table = 'ref_mthria';

    protected $fillable = [
        'mthria_code', 'mthria_desc',
    ];
}
