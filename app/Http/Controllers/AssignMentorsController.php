<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Staff;
use App\Student;
use App\Faculty;
use DB;
use App\Department;

class AssignMentorsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $departments = Department::all();
        $mentors = Staff::all(); 
        $students = DB::table('student_allotment')
                    ->join('student', 'student.uid', '=', 'student_allotment.uid')
                    ->join('term', 'term.term_id', '=', 'student_allotment.term_id')
                    ->where('term.branch',session('department_id'))
                    ->get();

        return view('faculty.pages.filterstudents')->with('departments',$departments);
    }

    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $mentors = Staff::all();
        $selectedStudents = $request->get('selected_students');
        
        if($request->get('selected_students') != null)
            return view('faculty.pages.toassign')->with('selectedStudents' ,$selectedStudents)->with('mentors', $mentors);
        else
            return redirect()->back()->with('error','No student selected');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // for showing student info
        $studentInfo = (Student::find($id));
        return view('faculty.pages.studentinfo') -> with ('studentInfo', $studentInfo);
    } 

    
}
