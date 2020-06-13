<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Faculty;

class SessionController extends Controller
{
    public function logout(Request $request){
        if(session('e_id') || session('uid')){
            if(session('e_id')){
                $faculty = Faculty::find(session('e_id'));
                date_default_timezone_set('Asia/Kolkata');
                $t=time();
                $faculty->last_active = date("Y-m-d H:i:s",$t);
                $faculty->save();
            }
            else{
                //Student last active to be updated
            }
            $request->session()->flush();
            return redirect('/')->with('success','Logged out Successfully!');
        }
        return redirect()->back()->with('error',str_rot13('Error Message !'));
        
    }

    public function home(){
        if(session('e_id')){
            return redirect('/staff/home');
        }
        else if(session('uid')){
            return redirect('/student');
        }
        return view('blank');
    }
}
