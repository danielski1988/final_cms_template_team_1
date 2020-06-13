<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Query extends Model
{
    protected $table = 'discussions';

    public $primaryKey = 'id';
}
