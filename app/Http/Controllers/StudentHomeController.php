<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use App\Faculty;
use App\Department;
use App\Faculty_teaching_staff;
use App\Student;
use Illuminate\Support\Facades\Input;
use App\Course_map;
use App\SubjectAllotment;
use App\Term;
use App\CtCC;
use App\Profile_images;
use File;
use Illuminate\Support\Facades\URL;
use Maatwebsite\Excel\Facades\Excel;
use App\Query;

class StudentHomeController extends Controller
{
    public function index(){
        if(session('uid')){
            return view('student.pages.home');
        }
        else{
            return redirect()->back()->with('error','Unauthorised Access');
        }
    }

    public function attend(){
        if(session('uid')){
            return view('student.pages.attendance');
        }
        else{
            return redirect()->back()->with('error','Unauthorised Access');
        }
    }
}
