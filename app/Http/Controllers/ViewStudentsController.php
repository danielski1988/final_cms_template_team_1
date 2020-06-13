<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Student;
use App\Staff;
use DB;
class ViewStudentsController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $mentor = Staff::where('e_id',$id)->get();
        $students = DB::table('student_allotment')
                    ->join('student', 'student.uid', '=', 'student_allotment.uid')
                    ->join('term', 'term.term_id', '=', 'student_allotment.term_id')
                    ->where('term.branch',session('department_id'))
                    ->get();
        return view('faculty.pages.viewstudent')->with('students',$students)->with('mentor',$mentor);
    }

}
