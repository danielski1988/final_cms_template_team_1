<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ThemeController extends Controller
{
    public function red(Request $request){
        $request->session()->forget('dark');
        session(['red' => true]);
        return redirect()->back()->with('success','Theme Changed Successfully');
    }

    public function dark(Request $request){
        $request->session()->forget('red');
        session(['dark' => true]);
        return redirect()->back()->with('success','Theme Changed Successfully');
    }
}
