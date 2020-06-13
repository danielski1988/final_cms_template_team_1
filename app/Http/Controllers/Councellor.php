<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Student;
use Input;

class Councellor extends Controller
{
    public function defaulter_list()  
    {          
        $query1=DB::select("Select d.dept_id,d.dept_name,s.e_id,sr.roles_id from department as d,dept_log as de,staff as s,staff_roles as sr where d.dept_id=de.department_id and  
                          s.e_id=de.e_id and s.e_id=sr.e_id");  
        $query=collect($query1)->first();  
        $query2=DB::select("Select s.e_id,sr.roles_id from staff as s,staff_roles as sr where  s.e_id=sr.e_id and sr.roles_id=2");  
        $query3=collect($query2)->first();
        $dept=Input::get('department');  
        $input=Input::get('Search');  
        $branch=Input::get('branch');  
        $students=Student::where('defaulter_action_needed','=','1' )->where('Class','=',$dept)->get();  
        if($query->roles_id==3)  
            return view("faculty.classCouncellor.defaulter_list",compact('dept','input'))->with('students',$students)->with('query',$query);  
       //if($query3->roles_id==2)  
       // {  
       //$student=DB::select("Select * from student where defaulter_action_needed='1' and Class='$dept' or Branch='$branch' ");
       //$students=collect($student);
       //return view("faculty.classCouncellor.defaulter_list_principal",compact('dept','input','branch'))->with('students',$students);
        
        if($dept==NULL)
        {
            if(session('e_id')){
                foreach(session('roles') as $role){
                    if($role == 7){
                        $query1=DB::select("Select d.dept_id,d.dept_name,s.e_id,sr.roles_id from department as d,dept_log as de,staff as s,staff_roles as sr where d.dept_id=de.department_id and  
                                            s.e_id=de.e_id and s.e_id=sr.e_id");  
                        $query=collect($query1)->first();  
                        $query2=DB::select("Select s.e_id,sr.roles_id from staff as s,staff_roles as sr where  s.e_id=sr.e_id and sr.roles_id=2");  
                        $query3=collect($query2)->first();
                        $dept=Input::get('department');  
                        $input=Input::get('Search');  
                        $branch=Input::get('branch');  
                        if($dept==NULL)
                        {
                            $student=DB::select("Select * from student where defaulter_action_needed='1' and Branch='$branch' ");
                            $students=collect($student);
                            $flag=0;
                        }
                        else
                        {
                            $student=DB::select("Select * from student where defaulter_action_needed='1' and Class='$dept' and  Branch='$branch' ");
                            $students=collect($student);
                            $flag=1;
                        }
                    
                    // if($query->roles_id==3)  
                        //return view("faculty.classCouncellor.defaulter_list",compact('dept','input'))->with('students',$students)->with('query',$query);  
                    if($query3->roles_id==2)  
                        {  
                        // $student=DB::select("Select * from student where defaulter_action_needed='1' and Class='$dept' ");
                        // $students=collect($student);
                        
                            return view("faculty.classCouncellor.defaulter_list_principal",compact('dept','input','branch','flag'))->with('students',$students);
                        } 
                        // else if($query->role_id==6)  
                        // return view("faculty.classCouncellor.defaulter_list_",compact('dept'))->with('students',$students)->with('query',$query);  
                        //else if($query->role_id==0)  
                        //return view("faculty.classCouncellor.defaulter_list_councellor",compact('dept'))->with('students',$students)->with('query',$query);  
                        //else   
                        // return view("faculty.classCouncellor.defaulter_list",compact('dept'))->with('students',$students)->with('query',$query);  
                    }
                }
                return redirect()->back()->with('error','Unauthorised Access');
            }
            else{
                return redirect()->back()->with('error','Unauthorised Access');
            }
        }
    }  
    public function defaulterList_Report()
    {
        $query1=DB::select("Select d.dept_id,d.dept_name,s.e_id,sr.roles_id from department as d,dept_log as de,staff as s,staff_roles as sr where d.dept_id=de.department_id and  
                          s.e_id=de.e_id and s.e_id=sr.e_id");  
        $query=collect($query1)->first();  
        $dept=Input::get('department');
        if($query->roles_id==3)  
       {  
          $student=DB::select("Select * from student where defaulter_action_needed='1' or Class='$dept'");
          $students=collect($student);
          return view("faculty.classCouncellor.defaulterlistReport",compact('dept','input','branch'))->with('students',$students);
       }
        
    }
}
