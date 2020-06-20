<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Staff;
use App\Student;
use DB;
use App\Role;
use App\Department;

class ToAssignController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $students = Student::all();
        $mentors = Staff::all();
        return view('faculty.pages.toassign')->with('mentors', $mentors)->with('students', $students);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    //  Make changes in database
    public function store(Request $request)
    {
        $departments = Department::all();

        // Gets array of 'uid' of selected students
        $selectedStudent = $request->get('selected_student');

        // Check if mentor is already present in the table
        if($request->input('mentor_id') != null) {
            $cmsRolesAll = Role::all();
            $isAssigned=0;
            $addToRoles = 0;

            foreach ($cmsRolesAll as $cmsRole) {
                if (($cmsRole->e_id==$request->input('mentor_id')) && ($cmsRole->roles_id==22)) {
                    $addToRoles = 1;
                }
            }

            //Add the mentor in the cms_roles table if not present already
            $cmsRolesCol = new Role;
            if ($addToRoles==0) {
                $cmsRolesCol->roles_id = 22;
                $cmsRolesCol->e_id = $request->input('mentor_id');
                $cmsRolesCol->save();
            }

            // Assigning (student's mentor_id) as (e_id of mentor)
            foreach($selectedStudent as $selected) {
                $student = Student::where('uid',$selected)->get();

                foreach ($student as $s) {
                    $s->mentor_id = $request->input('mentor_id');
                    $s->save();
                    $isAssigned=1;
                }
            }
        }
        else {
            $isAssigned=0;
        }
        // Redirect to previous page with message
        if ($isAssigned==1 ) {
            return redirect('/staff/filterstudents')->with('success', 'Mentor Assigned');
        }
        else {
            return redirect('/staff/filterstudents')->with('error', 'No Mentor Assigned');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $students = Student::where('uid',$id)->get();
        $mentors = Staff::all();
        return view('faculty.pages.toassign')->with('mentors', $mentors)->with('students', $students);
    }

}

