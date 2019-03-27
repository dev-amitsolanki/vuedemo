<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Complains extends Model
{
    protected $table = 'complains';

    protected $fillable = [
        'message_type','complain_to','related_for','message','user_id','name','status','closed_by','resolution','is_deleted','deleted_by'
    ];

    public function users(){
        return $this->belongsTo('App\User','user_id','id');
    }
}
