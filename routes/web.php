<?php



/*

|--------------------------------------------------------------------------

| Application Routes

|--------------------------------------------------------------------------
 
|

| Here is where you can register all of the routes for an application.

| It's a breeze. Simply tell Laravel the URIs it should respond to

| and give it the Closure to execute when that URI is requested.

|

*/


/**
 * Group Route to redirect all the routes with prefix faculty
 */


Route::group(['prefix'=>'staff', 'middleware' => 'admin'], function() {
    Route::get('/home', 'FacultyController@index');    
    Route::get('/attendance/faculty', 'FacultyController@facultyattendance');
    Route::get('search/', 'FacultyController@searchStudent'); 
    
    /* isAccessible route checks if th staff that has logged in is one of the assigned roles in cms_roles table*/ 
    Route::get('isAccessible','FacultyController@roles');  
    
    Route::get('profile','FacultyController@profile'); 
    
    /*MOST IMPORTANT FOR ADMIN*/  
    Route::resource('assignmentoradmin','AssignMentorAdminController');

    /*FOR MENTOR ADMINS*/
    Route::resource('assignmentor', 'AssignMentorsController');
    Route::resource('mentors', 'MentorsTableController');
    Route::resource('viewstudent', 'ViewStudentsController');
    Route::get('/check', 'FacultyController@roles');
    Route::resource('toassign', 'ToAssignController');
    Route::resource('filterstudents', 'FilterStudentsController');

    /*FOR MENTOR*/
    Route::get('/mymentees', 'MenteeController@mymentees');
    Route::group(['prefix'=>'mymentees'], function() {

        Route::get('/searchmentee', 'MenteeController@searchStudent');
        Route::resource('menteedetail', 'MenteeController');
    });


    //Route::get('/getAllClasses','FacultyController@showAllClasses');
    //Route::get('/faculty/match','FacultyController@matchFaculty');
});

/*FOR STUDENT*/
Route::group(['prefix'=>'student'], function() {

    Route::get('/home', 'StudentHomeController@index');   
    Route::resource('mentor', 'StudentsController');
    Route::get('/myattendance','StudentHomeController@attend');
    Route::get('/myattendance','StudentHomeController@attend');
    
});
Route::get('/student/edit', 'StudentsController@edit');

Route::group(['prefix' => 'theme'], function(){
    Route::get('/red', 'ThemeController@red');
    Route::get('/dark', 'ThemeController@dark');
});

Route::get('login', 'OauthController@login');
//Route::get('social/redirect/google', 'OauthController@redirectToProvider');
//Route::get('social/handle/google', 'OauthController@handleProviderCallback');
Route::resource('remarks', 'CommentController');
Route::get('/logout', 'SessionController@logout');
Route::get('/', 'SessionController@home');

?>


