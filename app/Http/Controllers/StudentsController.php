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

class StudentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $mentorid = DB::table('student')
            ->where('uid',session('uid'))->value('mentor_id');

        $mentordata = DB::table('staff')
            ->where('e_id',$mentorid)
            ->get();

        $mentorlogs = DB::table('discussions')
            ->orderBy('discussions.date','desc')
            ->join('staff','staff.e_id','=', 'discussions.e_id')
            ->join('student','student.uid','=','discussions.student_id')
            ->select('staff.email','staff.first_name','staff.last_name','staff.e_id','student.email_id','student.full_name','discussions.query','discussions.date','student.uid','discussions.description','discussions.id','discussions.time','discussions.created_by','student.mentor_id')
            ->get();
 
        return view('student.pages.viewmentors')->with('mentorid',$mentorid)->with('mentordata',$mentordata)->with('mentorlogs',$mentorlogs)->with('mentorid',$mentorid);

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

        //New Entry
        $query = new Query();
        $query->query = $request['query'];
        $query->description = $request['description'];
        $query->date = $request['date'];
        $query->time= $request['time'];
        $query->student_id = $request['s_id'];
        $query->e_id = $request['m_id'];
        $query->created_by = $request['created_by'];
        $query->save();
        

        return redirect('/student/mentor')->with('success', 'Success');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
       $student = DB::table('student')->where('uid', session('uid'))->get();
       return view('student.pages.editdiscussion')->with('discussion',$thisDiscussion)->with('student',$student);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */



/*
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
                ]);
        return redirect()->back()->with('Success','Query successfully edited');
    }
    */

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
        return redirect('/student/mentor')->with('success', 'Deleted');
    }
}
