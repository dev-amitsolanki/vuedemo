<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class MaintenanceDate extends Model
{
    protected $table = 'maintenance_dates';

    protected $fillable = [
        'm_date',
    ];
}
