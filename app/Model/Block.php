<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Block extends Model
{
    protected $table = 'blocks';

    protected $fillable = [
        'block','created_by'
    ];
}
