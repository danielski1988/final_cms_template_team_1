<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $table = 'student';

    protected $primaryKey = 'uid';

    public $timestamps =false;

    protected function comments()
    {
        return $this->hasMany('App\Comment','uid');
    }

    protected function applications()
    {
        return $this->hasMany('App\StudentApplication','uid');
    }

    protected function fepreacademic()
    {
        return $this->hasOne('App\FEPreAcademic','uid');
    }

    protected function dsepreacademic()
    {
        return $this->hasOne('App\DSEPreAcademic','uid');
    }

    public function studentList()
    {
        return $this->hasOne('App\StudentList', 'uid', 'uid');
    }
}
