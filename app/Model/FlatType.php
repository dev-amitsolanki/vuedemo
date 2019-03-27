<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class FlatType extends Model
{
    protected $table = 'flat_types';

    protected $fillable = [
        'flat_type','created_by'
    ];
}
