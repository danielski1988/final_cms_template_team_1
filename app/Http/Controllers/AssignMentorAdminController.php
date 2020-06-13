<?php

namespace App\Http\Controllers;
namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;
use App\Faculty;
use App\Department;
use App\Faculty_teaching_staff; 
use App\Student;
use App\Staff;

class AssignMentorAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $depts = Department::all();
        $mas = DB::table('cms_roles')
                    ->join('staff', 'staff.e_id','=','cms_roles.e_id')
                    ->join('department','department.id','=','staff.department_id')
                    ->select('staff.e_id', 'staff.email','staff.first_name','staff.last_name','staff.department_id','department.dept_name')
                    ->where('cms_roles.roles_id',21)
                    ->get();   
                         
        return view('faculty.pages.viewmentoradmins')->with('depts',$depts)->with('mas',$mas);
    }


    /**
     * Store the newly edited list of mentor admins.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $depts = Department::all();
        $dept_id = $request->get('dep');

        $allstaff = Staff::all();
        $mentoradmins = DB::table('cms_roles')
                ->join('staff', 'staff.e_id','=','cms_roles.e_id')
                ->select('cms_roles.e_id','staff.department_id','cms_roles.roles_id')
                ->where('cms_roles.roles_id',21)
                ->get();
        
        
        //return $request->faculty;
        foreach($mentoradmins as $ma)
        {
            if($dept_id == $ma->department_id && $ma->roles_id == 21) 
            {
                DB::table('cms_roles')->where('e_id',$ma->e_id)->where('roles_id',21)->delete();    
            }
        } 
        foreach($allstaff as $onestaff)
        {   
            if($request->get('ma') != null)
            {
                if(in_array($onestaff->e_id, $request->get('ma')))
                {            
                    $sql = "INSERT INTO cms_roles(roles_id, e_id) VALUES (21, $onestaff->e_id)";
                    DB::insert($sql);
                }
            }
        }
        if($request->get('ma') == null)
            return redirect('/staff/assignmentoradmin')->with('error','No Mentor Admin chosen!');
        else
        {
            $count = count($request->get('ma'));
            if($count == 1)
                return redirect('/staff/assignmentoradmin')->with('success','Mentor Admin assigned');            
            else
                return redirect('/staff/assignmentoradmin')->with('success','Mentor Admins assigned');
        }
    }

    /**
     * Display the list of staff present in that department for selection as mentor admin
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {        
        $depts = Department::where('id',$id)->first();
        $allstaff = Staff::where('type',1)->get();
        $mentoradmins = DB::table('cms_roles')
                ->select('cms_roles.e_id')
                ->where('cms_roles.roles_id',21)
                ->get();                    
        return view('faculty.pages.changementoradmin')->with('depts',$depts)->with('allstaff',$allstaff)->with('mentoradmins',$mentoradmins);
    }
}
