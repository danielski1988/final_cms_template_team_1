<?php

namespace App\Http\Controllers;

use Socialite;
use App\Student;
use App\Faculty;
use App\Role;
use App\Google;
use Illuminate\Http\Request;

class OauthController extends Controller
{ 
    /**
     * Redirect the user to the GitHub authentication page.
     *
     * @return Response
     */
    // public function redirectToProvider()
    // {
    //     return Socialite::driver('google')->redirect();
    // }

    public function login(Google $google, Request $request)
   {
        $client = $google->client();
        if ($request->has('code')) {

            $client->authenticate($request->get('code'));
            $token = $client->getAccessToken();

            $plus = new \Google_Service_Plus($client);

            $google_user = $plus->people->get('me');

            $id = $google_user['id'];

            $userEmail = $google_user['emails'][0]['value'];
            
            $staff = Faculty::where('email', '=', $userEmail)->first();
            $student = Student::where('email_id','=', $userEmail)->first();

            if(isset($staff)){
                session(['e_id' => $staff->e_id]);
                $role = Role::where('e_id', '=', $staff->e_id)->get();

                $roles = array();
                $types = array();

                if($staff->type == 1){
                    array_push($types, 1);
                }
                else{
                    array_push($types, 2);
                }
                
                foreach($role as $r){
                    array_push($roles, $r->roles_id);
                }
                session(['email' => $userEmail]);
                session(['first_name' => $staff->first_name]);
                session(['last_name' => $staff->last_name]);
                session(['roles' => $roles]);
                session(['types' => $types]);
                session(['department_id' => $staff->department_id]);
                header("Cache-Control", "no-cache, no-store, must-revalidate");
                return redirect('/staff/home')->with('success','Login Successfull !');
            }
            else if(isset($student)){
                session(['uid' => $student->uid]);
                session(['email' => $userEmail]);
                return redirect('/student/home')->with('success','Login Successfull !');
            }
            else{
                return redirect('/')->with('error','Your record is not found ! Contact CMS Administrator.');
            }
        } else {
            $auth_url = $client->createAuthUrl();
            return redirect($auth_url);
        }
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return Response
     */

    public function handleProviderCallback()
    {
        $user = Socialite::driver('google')->stateless()->user();
        
        $userEmail = $user->getEmail();
        
        $uid = Student::where('EmailId','=',$userEmail)->get()->UID;
        $staff = Faculty::where('email', '=', $userEmail)->first();
        $student = Student::where('email_id','=', $userEmail)->first();

        if(isset($staff)){
            session(['e_id' => $staff->e_id]);
            $role = Role::where('e_id', '=', $staff->e_id)->get();

            $roles = array();
            $types = array();

            if($staff->type == 1){
                array_push($types, 1);
            }
            else{
                array_push($types, 2);
            }
            
            foreach($role as $r){
                array_push($roles, $r->roles_id);
            }
            session(['email' => $userEmail]);
            //session(['role_id' => $role]);
            session(['first_name' => $staff->first_name]);
            session(['last_name' => $staff->last_name]);
            session(['roles' => $roles]);
            session(['types' => $types]);            
            header("Cache-Control", "no-cache, no-store, must-revalidate");
            return redirect('/staff/home')->with('success','Login Successfull !');
        }
        else if(isset($student)){
            session(['uid' => $student->uid]);
            session(['email' => $userEmail]);
            return redirect('/student')->with('success','Login Successfull !');
        }
        else{
            return redirect('/')->with('error','Your record is not found ! Contact CMS Administrator.');
        }

        
    }
 }