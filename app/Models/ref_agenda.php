<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use OwenIt\Auditing\Auditable;

class ref_agenda extends Model
{

    protected $table = 'ref_agenda';

    protected $fillable = [
        'agenda_code', 'agenda_desc',
    ];
}
