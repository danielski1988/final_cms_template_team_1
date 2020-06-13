<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Staff;
use App\Student;
use App\Faculty;
use DB;


class FilterStudentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $mentors = Staff::all();
        $students = DB::table('student_allotment')
                    ->join('student', 'student.uid', '=', 'student_allotment.uid')
                    ->join('term', 'term.term_id', '=', 'student_allotment.term_id')
                    ->where('term.branch',session('department_id'))
                    ->where('term.semester', session('semester'))
                    ->where('student_allotment.division', session('division'))
                    ->get();

        return view('faculty.pages.assignmentor')->with('mentors', $mentors)->with('students', $students);
    }

    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        session(["semester"=>$request->input('semester')]);
        session(["division"=>$request->input('division')]);
        $semester = $request->input('semester');
        $division = $request->input('division');
        $mentors = Staff::all();
        $students = DB::table('student_allotment')
                    ->join('student', 'student.uid', '=', 'student_allotment.uid')
                    ->join('term', 'term.term_id', '=', 'student_allotment.term_id')
                    ->where('term.branch',session('department_id'))
                    ->where('term.semester', $semester)
                    ->where('student_allotment.division', $division)
                    ->get();
        $count=0;
        foreach($students as $s)
        {
            $count++;
        }
        if(!($count==0))
                return view('faculty.pages.assignmentor')->with('mentors', $mentors)->with('students', $students);
            else 
                return redirect()->back()->with('error','No Students Found!');
        
    }

}
