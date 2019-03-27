<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class MaintenanceCharges extends Model
{
    protected $table = 'maintenance_charges';

    protected $fillable = [
        'member_type','flat_type','m_charge','late_fee'
    ];
}
