<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Student;
use App\Department;
use App\Staff;
use DB;

class MentorsTableController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $departments = Department::all();
        $students = DB::table('student_allotment')
                    ->join('student', 'student.uid', '=', 'student_allotment.uid')
                    ->join('term', 'term.term_id', '=', 'student_allotment.term_id')
                    ->where('term.branch',session('department_id'))
                    ->get();
        $mentors = DB::table('cms_roles')
                    ->where('roles_id', 22)
                    ->join('staff', 'staff.e_id', '=', 'cms_roles.e_id')
                    ->get();
        return view('faculty.pages.mentortable')->with('mentors', $mentors)->with('students',$students)->with('departments',$departments);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $mentorInfo = Staff::find($id);
        return view ('faculty.pages.mentorinfo') -> with ('mentorInfo', $mentorInfo);
    }

}
