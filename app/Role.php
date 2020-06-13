<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'cms_roles';

    //Timestamp
    public $timestamps = false;
}
