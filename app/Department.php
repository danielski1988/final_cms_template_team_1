<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $table = 'department';

    //Primary Key
    protected $primaryKey = 'id';
    //Timestamp
    public $timestamp =false;
    
}
