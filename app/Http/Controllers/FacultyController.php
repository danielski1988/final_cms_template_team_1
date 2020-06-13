<?php

namespace App\Http\Controllers;
use DB; 
use Illuminate\Http\Request;
use App\Faculty;
use App\Department;
use App\Faculty_teaching_staff;
use App\Student;
use App\Staff;
use Illuminate\Support\Facades\Input;
use App\Course_map;
use App\SubjectAllotment;
use App\Term;
use App\CtCC;
use App\Profile_images;
use File;
use Illuminate\Support\Facades\URL;
use Maatwebsite\Excel\Facades\Excel;

class FacultyController extends Controller
{
    /**
     * Route to faculty dashboard, Connects databases and passes database object to dashboard
     *
     * @return view home with database object
     */
    public function index(){
        if(session('e_id')){
            return view('faculty.pages.home');
        }
        else{
            return redirect()->back()->with('error','Unauthorised Access');
        }
    }

    public function showAllClasses()
    {
        $allClasses = DB::table('student_allotment')
                        ->join('student','student.uid','=','student_allotment.uid')
                        ->join('term','term.term_id','=','student_allotment.term_id')
                        ->get();
        return view('faculty.pages.allClasses')->with('all',$allClasses);
    }
    
    /** 
     * Redirects to roles and responsibility page of faculty 
     *
     * @return view 
     */
    public function roles(){
        if(session('e_id')){
            foreach(session('roles') as $role){
                if($role == 0){
                    return redirect('/staff/assignmentoradmin');
                }
                if($role == 21){
                    return redirect('/staff/home');
                }
                if($role == 22){
                    return redirect('/staff/home');
                }
            }
            return redirect()->back()->with('error','Unauthorised Access');
        }
        else{
            return redirect()->back()->with('error','Unauthorised Access');
        }
    }

    /**
     * Route to profile page of faculty
     *
     * @return profile view and faculry database objects 
     */
    public function profile(Request $request){
        
        if(session('e_id')){
            $e_id =  $request->session()->get('e_id'); //Later found by auth
            $faculty = Faculty::find($e_id);
            $department = Department::find($faculty->department_id);
            // return $department;
            //$profilePic = Profile_images::find($e_id);
            // return $profilePic;
            
            return view('faculty.pages.profile')->with('staff', $faculty)->with('department',$department);
        }
        else{
            return redirect()->back()->with('error','Unauthorised Access');
        }
    }

    public function searchStudent(){
        if(session('e_id')){
            $term = Input::get('q');

            if(strlen($term) == 0){
                return redirect()->back()->with('error','Please enter first name or last name to search');
            }

            $results = array();
            
            $queries = DB::table('student')->where('uid', '=', $term)
            ->orwhere('email_id', '=', $term)
            ->orWhere('first_name', 'like', $term.'%')
            ->orWhere('middle_name', 'like', $term.'%')
            ->orWhere('last_name', 'like', $term.'%')            
            ->get();
            
            return view('faculty.pages.searchstudent') ->with ("students",$queries);
        }
        else{
            return redirect()->back()->with('error','Unauthorised Access');
        }
    }
    /**
     * Redirect to attendance page of student
     *
     * @return view and database objects
     */
    public function studentattendance(){
        if(session('e_id')){
            $eid='464';
            $year="16";
            $month=date("m");
            if($month>6)
            {
                $subject_details = DB::select("select s.division,s.sub_allotment_id,c.course_name,c.course_code,c.term_id,s.contact_head from course_map as c join subject_allotment as s on c.course_code=s.course_code and c.term_id=s.term_id where s.e_id= '$eid' and s.term_id like '$year%' and s.term_id%2=1");
            }
            else
            {
                $subject_details = DB::select("select s.division,s.sub_allotment_id,c.course_name,c.course_code,c.term_id,s.contact_head from course_map as c join subject_allotment as s on c.course_code=s.course_code and c.term_id=s.term_id where s.e_id= '$eid' and s.term_id like '$year%' and s.term_id%2=0");
            }
            return view('faculty.pages.studentattendance',['subject_details' => $subject_details],['students' => 'NULL']);
        }
        else{
            return redirect()->back()->with('error','Unauthorised Access');
        }
        
    }

    public function addingstudentattendance(Request $request){
        if(session('e_id')){
            return view('faculty.pages.addAttendanceRecord',['data' => $request]);
        }
        else{
            return redirect()->back()->with('error','Unauthorised Access');
        }
        
    }

    public function getStudentRecord(Request $request){
        if(session('e_id')){
            $date = $request->get("date");
            $div = $request->get("div");
            $termid = $request->get("termid");
            $suballotid = $request->get("suballotid");
            $data = DB::select("select s.FirstName,s.LastName,sa.roll_no,sa.UID from student as s join student_allotment as sa on s.UID=sa.UID where sa.term_id='$termid' and sa.division='$div' order by sa.roll_no");
            return view('faculty.pages.addAttendanceRecord',['data' => $request],['students' => $data]);
        }
        else{
            return redirect()->back()->with('error','Unauthorised Access');
        }
        
    }

    /**
     * Redirect to attendance page of faculty
     *
     * @return view and database objects
     */
    public function facultyattendance(){
        if(session('e_id')){
            return view('faculty.pages.facultyattendance');
        }
        else{
            return redirect()->back()->with('error','Unauthorised Access');
        }
    }
    public function attendance(){
        if(session('e_id')){
            return view('faculty.pages.attendance');
        }
        else{
            return redirect()->back()->with('error','Unauthorised Access');
        }
    }

    

    /**
     * Redirects to courses taught by the teaching staff page
     *
     * @return courses view and database object
     */
    public function courses(){
        
        if(session('e_id')){
            foreach(session('types') as $type){
                if($type == 1){
                    $e_id = session('e_id');
                    $subjects = SubjectAllotment::where('e_id' ,'=', $e_id)->get();

                    $subYears = array();
                    
                    foreach($subjects as $subject){
                        $term = Term::find($subject->term_id);
                        $course = Course_map::find($subject->course_code);

                        $subject['scheme'] = $term->scheme;
                        $subject['courseName'] = $course->course_name;
                        $subYears[$term->academic_year][$term->semester][] = $subject;
                    }
                    
                    return view('faculty.pages.courses')->with('subjects', $subYears);
                }
            }
            return redirect()->back()->with('error','Unauthorised Access');
        }
        else{
            return redirect()->back()->with('error','Unauthorised Access');
        }
    }

    public function submitDriveLink(Request $request){

        if(session('e_id')){
            foreach(session('types') as $type){
                if($type == 1){

                    $drive_link = $request->input("gdl");
                    $classroom_link = $request->input("crl");
                    $sub_id = $request->input("sub_id");

                    $subject = SubjectAllotment::find($sub_id);
                    $subject->drive_link = $drive_link;
                    $subject->classroom_link = $classroom_link;
                    $subject->save();  

                    return redirect()->back()->with('success','Links updated');         
                }
            }
            return redirect()->back()->with('error','Unauthorised Access');
        }
        else{
            return redirect()->back()->with('error','Unauthorised Access');
        }
    }


    /**
     * redirect to report generation page where table will be displayed according to 
     * filters and export option will be provided 
     *
     * @return view and database objects
     */
    public function report(){
        
        if(session('e_id')){
            foreach(session('roles') as $role){
                if($role == 3){
                    return view('faculty.pages.report');
                }
            }
            return redirect()->back()->with('error','Unauthorised Access');
        }
        else{
            return redirect()->back()->with('error','Unauthorised Access');
        }
    }

    public function uploadImage(){        
        return view('faculty.pages.uploadImage');
    }



    public function generate_report(request $request){
        $this -> validate($request, [
            'year' =>'required'
        ]);
        //$data='Hello';
        $selected_dep = $request -> input('department');
        $selected_staff = $request -> input('staffType');
        $selected_contract = $request -> input('contractType');
        $selected_year = $request -> input('year');  
        $current_year= date('Y');
        $year_diff=$current_year - $selected_year;
        $query = "SELECT f.first_name, f.last_name, f.e_id, f.type, f.email, 
                                    d.dept_name, dl.start_date, dl.end_date from faculty as f inner join dept_log 
                                    as dl ON dl.e_id = f.e_id INNER JOIN department as d ON d.dept_id = dl.department_id INNER JOIN teaching_staff as t 
                                    ON t.e_id = f.e_id WHERE ((YEAR(dl.start_date) >= $year_diff) or (YEAR(dl.start_date) < $year_diff AND YEAR(dl.end_date)>= $year_diff) 
                                    or (YEAR(dl.start_date) < $year_diff AND YEAR(dl.end_date)=NULL) AND(t.type)=$selected_contract AND(d.dept_id = $selected_staff))"  ;
        $query2 = "SELECT f.first_name, f.last_name, f.e_id, f.type, f.email, d.dept_name, t.start_date from faculty as f inner join dept_log as dl ON dl.e_id = f.e_id INNER JOIN department as d ON d.dept_id = dl.department_id INNER JOIN teaching_staff as t ON t.e_id = f.e_id WHERE d.dept_name = '$selected_dep' AND ((YEAR(dl.start_date) >= $year_diff) OR (YEAR(dl.start_date) < $year_diff AND YEAR(dl.end_date)>= $year_diff) OR (YEAR(dl.start_date) < $year_diff AND YEAR(dl.end_date)=NULL))";
        $data = DB::select($query2);
        echo "$query2";
        return $data;
        //return $year_diff;  

        
           //return view('faculty.pages.report')->with('data',$data);
    }

     public function exam(){
        
        if(session('e_id')){
            foreach(session('roles') as $role){
                if($role == 303){
                    return view('faculty.pages.exam');
                }
            }
            return redirect()->back()->with('error','Unauthorised Access');
        }
        else{
            return redirect()->back()->with('error','Unauthorised Access');
        }
    }
    
    public function syllabus(){
        
        if(session('e_id')){
            foreach(session('roles') as $role){
                if($role == 4){
                    return view('faculty.pages.syllabus');
                }
            }
            return redirect()->back()->with('error','Unauthorised Access');
        }
        else{
            return redirect()->back()->with('error','Unauthorised Access');
        }
    }
    
    public function bookevent(){
        
        if(session('e_id')){
            return view('faculty.pages.booking_form');
        }
        else{
            return redirect()->back()->with('error','Unauthorised Access');
        }
    }
      public function defaulter_list() 
    { 
        if(session('e_id')){
            return view('faculty.classCouncellor.defaulter_list'); 
        }
        else{
            return redirect()->back()->with('error','Unauthorised Access');
        }
    }

    public function courseassign(Request $request){
        if(session('e_id')){
            foreach(session('roles') as $role){
                if($role == 9){
                    
                    if(isset($request->course))
                    {
                        $char = substr($request->year, 2,2);
                        $term = "".$char."".$request->course."".$request->branch."".$request->sem;
                        $term_id = (int)$term;

                        $div = $request->division;
                        $courses = Course_map::where('term_id', '=',$term_id)->get();
                        $request->session()->put('courses', $courses);
                        $request->session()->put('div', $div);
                        // return $courses;
                        // http://cms.com/staff/course/assign?year=2016&course=0&branch=1&sem=3&division=1


                        $subAllotment = SubjectAllotment::where('term_id','=',$term_id)
                        ->where('division','=',chr($div+64))->get();

                        if(count($subAllotment) > 0){
                            return redirect('staff/course/assign')->with('success','Staff Already Alloted');
                        }
                        else{
                            if(count($courses) > 0){
                                return view('faculty.syllabus.staffAssign')->with('div',$div)->with('courses',$courses);
                            }
                            else{
                                return redirect('staff/course/assign')->with('error','Scheme not found! Please enter syllabus scheme');
                            }
                        }
                    }
                    else{
                        return view('faculty.syllabus.staffAssign');
                    }
                }
            }
            return redirect()->back()->with('error','Unauthorised Access');
        }
        else{
            return redirect()->back()->with('error','Unauthorised Access');
        }
        
        
    }

    public function loadGeneration(Request $request){
        if(session('e_id')){
            foreach(session('roles') as $role){
                if($role == 1 || $role == 2){
                    
                    if(isset($request->course))
                    {
                        $char = substr($request->year, 2,2);
                        $term = "".$char."".$request->course."".$request->branch."".$request->sem;
                        $term_id = (int)$term;

                        $allotments = SubjectAllotment::where('term_id', '=', $term)->get();

                        //return $allotments[0]->course_id;

                        foreach($allotments as $allotment){
                            $course = Course_map::find($allotment->course_code);
                            $staff = Faculty::find($allotment->e_id);
                            $allotment->course_name = $course->course_name;
                            $allotment->first_name = $staff->first_name;
                            $allotment->last_name = $staff->last_name;

                            // return $allotment;
                        }

                        if(count($allotments) >0){
                            return view('faculty.pages.load_generate')->with('allotments', $allotments);
                        }

                        return redirect('/staff/generate/load')->with('error', 'Term staff not alloted yet');
                        
                    }
                    else{
                        return view('faculty.pages.load_generate');
                    }
                }
            }
            return redirect()->back()->with('error','Unauthorised Access');
        }
        else{
            return redirect()->back()->with('error','Unauthorised Access');
        }
    }

    public function matchFaculty(Request $request){
        if(session('e_id')){
            foreach(session('roles') as $role){
                if($role == 4 || $role == 9 || $role == 8 || $role == 0){
                    $term = $request->term;
                    $match = Faculty::where('e_id','=',$term)
                    ->orWhere('short_form','=',$term)
                    ->orWhere('first_name','=',$term)
                    ->orWhere('last_name','=',$term)
                    ->first();
                    return response()->json($match);
                }
            }
            return redirect()->back()->with('error','Unauthorised Access');
        }
        else{
            return redirect()->back()->with('error','Unauthorised Access');
        }
        

    }

    public function submitCourse(Request $request){

        if(session('e_id')){
            foreach(session('roles') as $role){
                if($role == 9){
                    // Get courses and div from pervious form
                    $courses = $request->session()->get('courses');
                    $div = $request->session()->get('div');
                    

                    foreach($courses as $course){
                        if($course->th_hrs > 0){
                            for($i=0; $i < $course->th_hrs; $i++){
                                $inputfield = "hth_".str_replace(' ', '', $course->course_code);
                                
                                $e_id = intval($request->input($inputfield));
                                // return $e_id;

                                $assign = new SubjectAllotment;

                                $assign->term_id = $course->term_id;
                                $assign->course_code = $course->course_code;
                                $assign->division = chr($div+64);
                                $assign->contact_head = 'TH';
                                $assign->contact_head_hours = 1;
                                $assign->e_id = $e_id;

                                $previous = SubjectAllotment::where('term_id','=',$assign->term_id)
                                ->where('course_code','=',$assign->course_code)
                                ->where('division','=',$assign->division)
                                ->where('contact_head','=',$assign->contact_head)
                                ->where('e_id','=',$assign->e_id);

                                $previousData = $previous->get();

                                //return $previousData;

                                if(count($previousData) > 0){
                                    $contact_hours = intval($previousData[0]->contact_head_hours)+1;
                                    $s_id = $previous->get()->first()->sub_allotment_id;
                                    $sub = SubjectAllotment::find($s_id);
                                    $sub->contact_head_hours = $contact_hours;
                                    $sub->save();
                                }
                                else{
                                    $assign->save();
                                }
                            }
                        }

                        if($course->pr_hrs > 0){
                            for($i=0; $i < $course->pr_hrs; $i++){
                                $batches = array_map('intval', explode(',',$course->pr_batches));
                                $batchCount = $batches[$div-1];
                                for($j=0; $j<$batchCount; $j++){
                                    $inputfield = "hph_".str_replace(' ', '', $course->course_code).'_'.chr($j+65);
                                    
                                    $e_id = intval($request->input($inputfield));
                                    // return $e_id;

                                    $assign = new SubjectAllotment;

                                    $assign->term_id = $course->term_id;
                                    $assign->course_code = str_replace(' ', '', $course->course_code);
                                    $assign->division = chr($div+64);
                                    $assign->contact_head = 'PR'.'-'.chr($j+65);
                                    $assign->contact_head_hours = 1;
                                    $assign->e_id = $e_id;

                                    $previous = SubjectAllotment::where('term_id','=',$assign->term_id)
                                    ->where('course_code','=',$assign->course_code)
                                    ->where('division','=',$assign->division)
                                    ->where('contact_head','=',$assign->contact_head)
                                    ->where('e_id','=',$assign->e_id);

                                    $previousData = $previous->get();

                                    //return $previousData;

                                    if(count($previousData) > 0){
                                        $contact_hours = intval($previousData[0]->contact_head_hours)+1;
                                        $s_id = $previous->get()->first()->sub_allotment_id;
                                        $sub = SubjectAllotment::find($s_id);
                                        $sub->contact_head_hours = $contact_hours;
                                        $sub->save();
                                    }
                                    else{
                                        $assign->save();
                                    } 
                                }
                            }
                        }

                        if($course->tut_hrs > 0){
                            for($i=0; $i < $course->tut_hrs; $i++){
                                $batches = array_map('intval', explode(',',$course->tut_batches));
                                $batchCount = $batches[$div-1];
                                for($j=0; $j<$batchCount; $j++){
                                    $inputfield = "huh_".str_replace(' ', '', $course->course_code).'_'.chr($j+65);
                                    
                                    $e_id = intval($request->input($inputfield));
                                    // return $e_id;

                                    $assign = new SubjectAllotment;

                                    $assign->term_id = $course->term_id;
                                    $assign->course_code = str_replace(' ', '', $course->course_code);
                                    $assign->division = chr($div+64);
                                    if($batchCount > 1){
                                        $assign->contact_head = 'TUT'.'-'.chr($j+65);
                                    }
                                    else{
                                        $assign->contact_head = 'TUT';
                                    }
                                    $assign->contact_head_hours = 1;
                                    $assign->e_id = $e_id;

                                    $assign->save();
                                }
                            }
                        }
                    }

                    $request->session()->forget('courses');
                    $request->session()->forget('div');
                    return redirect('staff/course/assign/')->with('success','Staff alotted Successfully');
                }
            }
            return redirect()->back()->with('error','Unauthorised Access');
            
        }
        else{
            return redirect()->back()->with('error','Unauthorised Access');
        }
        
        

    }

    public function assignCTCC()
    {
        if(session('e_id')){
            foreach(session('roles') as $role){
                if($role == 8)
                {
                    $path = URL::to('json/CourseConfig.json');
                    $json = json_decode(file_get_contents($path), true);
                    $date = date("Y/m/d");
                    foreach($json['term_span_details'] as $term)
                    {
                        if(strtotime($date) >= strtotime($term['start_date']) && strtotime($date) <= strtotime($term['end_date']))
                        {
                            $sem = $term['semester'];
                        }
                    }
                    $terms = Term::where("academic_year","=",date("Y"))->get();
                    $term_array = array();
                    
                    //return $terms;
                    if($sem == "odd")
                    {
                        foreach($terms as $term)
                        {
                            if(((int)$term->semester) % 2 == 1)
                            {
                                array_push($term_array,$term);
                            }
                        }
                        //return $term_array;
                    }
                    else if($sem == "even")
                    {
                        foreach($terms as $term)
                        {
                            if(((int)$term->semester) % 2 == 0)
                            {
                                array_push($term_array,$term);
                            }
                        }
                        //return $term_array;
                    }
                    else
                    {
                        return "error";
                        return redirect('faculty.pages.assignClassTeachers')->with('error','Some Error Occurred regarding Even/Odd Semester');
                    }
                    

                    //assign number of divisions to a particular term
                    $division_array = array();
                    foreach($term_array as $term)
                    {
                        $div = Course_map::where("term_id","=",$term['term_id'])->first();
                        $divisions = substr_count($div['tut_batches'],',') +1;
                        //return $divisions;
                        array_push($division_array,$divisions);
                    }

                    $term_ids = array();
                    foreach($term_array as $term)
                    {
                        array_push($term_ids,$term->term_id);
                    }
                    
                    $term_data = array_combine($term_ids,$division_array);
                    //return $term_data;
                    session(['term_data' => $term_data]);
                    return view('faculty.pages.assignClassTeachers')->with('json',$json)
                                                                    ->with('division_array',$division_array)
                                                                    ->with('term_data',$term_data);
                }
            }
            return redirect()->back()->with('error','Unauthorised Access');
        }
        else{
            return redirect()->back()->with('error','Unauthorised Access');
        }
    }

    public function addCTCC(Request $request)
    {
        if(session('e_id')){
            foreach(session('roles') as $role)
            {
                if($role == 8)
                {
                    $test = array();
                    foreach(session('term_data') as $term => $num_of_div)
                    {
                        for($i=0;$i<$num_of_div;$i++)
                        {
                            $eid_ct = $request->input("ct_".$term."_".chr($i + 65));
                            $eid_cc = $request->input("cc_".$term."_".chr($i + 65));
                            
                            //insert into table
                            $ctcc = new CtCC;
                            $ctcc->term_id = $term;
                            $ctcc->class = chr($i + 65);
                            $ctcc->class_teacher_eid = $eid_ct;
                            $ctcc->class_counsellor_eid = $eid_cc;
                            $ctcc->save();
                            //array_push($test,$name);
                        }
                    }
                    $request->session()->forget('term_data');
                    return redirect()->back()->with('success','Class Teachers and Counsellors added');
                }
            }
            return redirect()->back()->with('error','Unauthorised Access');
        }
        else{
            return redirect()->back()->with('error','Unauthorised Access');
        }
    }

    public function excel()
    {
    
        $staff_data= Faculty::all(['e_id','first_name','last_name','short_form','department_id','designation','email','mobile','landline','Expertise']);
        $staff_data_array = [];
        $staff_data_array[] = ['e_id','Name','Last Name','Short Form','Department Id','Designation','Email','Mobile','LandLine','Expertise'];
        foreach ($staff_data as $data)
        {
            $staff_data_array[] = $data->toArray();
        }
        $this->globals =  $staff_data_array;

        Excel::create('staff', function($excel) {

            // Set the spreadsheet title, creator, and description
            $excel->setTitle('Staff Data');
            $excel->setCreator('Laravel')->setCompany('WJ Gilmore, LLC');
            $excel->setDescription('staff details');
            $staff_data_array = $this->globals;
            // Build the spreadsheet, passing in the payments array
            $excel->sheet('sheet1', function($sheet) use ($staff_data_array) {
                $sheet->fromArray($staff_data_array, null, 'A1', false, false);
            });

        })->download('csv');

 
    }

    
    public function report_rid_13()
    {
        return view('faculty.pages.report_rid_13');
    }

    public function generate_list_with_doj(Request $request)
    {
        $this -> validate($request, [
            'year_doj' =>'required'
        ]);
        //return $request -> input('year_doj');
        //$selected_year = $request -> input('year');  
        $current_year= date('Y');
        $year_diff=$current_year - $request -> input('year_doj');
        $data = Faculty::whereYear('doj','>',$year_diff)
                        ->where('type','=','1')
                        ->get(['e_id','doj','first_name','last_name']); 
         
        return view('faculty.pages.report_rid_13')->with('data',$data); 
    }

}

?>