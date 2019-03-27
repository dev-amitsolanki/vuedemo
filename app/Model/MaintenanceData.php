<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class MaintenanceData extends Model
{
    protected $table = 'maintenance_datas';

    protected $fillable = [
        'flat_no','month','maintenace','status','paid'
    ];
}
