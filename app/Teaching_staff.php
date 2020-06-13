<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Teaching_staff extends Model
{
     protected $table = 'teaching_staff';

    //Primary Key

    protected $primaryKey = 'e_id';
    //Timestamp
    public $timestamp =false;

    public function faculty(){
        return $this->belongsTo('App\Faculty');
    }
}
