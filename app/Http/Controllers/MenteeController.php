<?php

namespace App\Http\Controllers;
use DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Faculty;
use App\Department;
use App\Faculty_teaching_staff;
use App\Student;
use App\Query;
use Illuminate\Support\Facades\Input;
use App\Course_map;
use App\SubjectAllotment;
use App\Term;
use App\CtCC;
use App\Profile_images;
use File;
use Illuminate\Support\Facades\URL;
use Maatwebsite\Excel\Facades\Excel;

class MenteeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        DB::table('discussions')->where('id',$request->id)->delete();
        $this->validate($request, [
            'date' => 'required',
            'time' => 'required',
            'query' => 'required',
            'description' => 'required',
        ]);
        
        $uid1 = $request['s_id'];
        //New Entry
        $query = new Query();
        $query->query = $request['query'];
        $query->description = $request['description'];
        $query->date = $request['date'];
        $query->time = $request['time'];
        $query->student_id = $request['s_id'];
        $query->e_id = $request['m_id'];
        $query->created_by = $request['created_by'];
        $query->save();
        
        return redirect('/staff/mymentees/menteedetail/'.$uid1)->with('success', 'Success');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // This function helps in showing the info of a mentee when its uid is clicked
    public function show($uid)
    {
        if(session('e_id'))
        {
            $detail = Student::find($uid);
            $log = DB::table('discussions')
                    ->select('discussions.description','discussions.id','discussions.date','discussions.time',
                            'discussions.query','discussions.e_id','discussions.student_id','discussions.created_by')
                    ->get();
            return view('faculty.pages.menteedetail')->with('detail', $detail)->with('log', $log);
        }
        else
        {
            return redirect()->back()->with('error','Unauthorised Access');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $thisDiscussion = DB::table('discussions')->where('id',$id)->get();
        $student = DB::table('student')->where('mentor_id', session('e_id'))->get();
        return view('faculty.pages.editdiscussion')->with('discussion',$thisDiscussion);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $this->validate($request, [
            'date' => 'required',
            'time' => 'required',
            'query' => 'required',
            'description' => 'required',
        ]);

        $edit = DB::table('discussions')
                ->where('id',$request->id)
                ->update([
                    'query' => $request['query'],
                    'description' => $request['description'],
                    'date' => $request['date'],
                    'time' => $request['time'],
                    'student_id' => $request['s_id'],
                    'e_id' => $request['m_id']
                ]);
                
        return redirect()->back()->with('Success','Discussion is successfully edited');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $query = Query::find($id);
        $query->delete();
        return redirect()->back()->with('Success','Discussion is successfully deleted');

    }

    // This function is for showing the uid, name and email id of all the mentees that mentor has in the My Mentees Tab
    public function mymentees()
    {
        if(session('e_id'))
        {
            $departments = Department::all();
            $mentees = DB::table('student_allotment')
                        ->join('student','student.uid','=','student_allotment.uid')
                        ->join('term','term.term_id','=','student_allotment.term_id')
                        ->where('student.mentor_id',session('e_id'))
                        ->get();
            return view('faculty.pages.facultymentees')->with('mentees',$mentees)->with('departments',$departments);
        }
        else
        {
            return redirect()->back()->with('error','Unauthorised Access');
        }
    }

    // This function is for showing the respective mentees which are found after selecting the options in the drop down box
        // This function shows the selected mentee from the list of mentees found earlier
    public function searchStudent(Request $request)
    {
        if(session('e_id'))
        {
            $branch = $request->input('branch');
            $semester = $request->input('semester', 'Choose a semester');
            $division = $request->input('division', 'Choose a division');
            $departments = Department::all();
            $mentees = DB::table('student_allotment')
                        ->join('student','student.uid','=','student_allotment.uid')
                        ->join('term','term.term_id','=','student_allotment.term_id')
                        ->where('term.branch',session('department_id'))
                        ->where('term.semester', '=', $semester)
                        ->where('student_allotment.division', '=', $division)
                        ->where('student.mentor_id',session('e_id'))
                        ->get();
            return view('faculty.pages.searchmentee')->with('mentees',$mentees)->with('departments',$departments);
        }
        else
        {
            return redirect()->back()->with('error','Unauthorised Access');
        }
    }
}
