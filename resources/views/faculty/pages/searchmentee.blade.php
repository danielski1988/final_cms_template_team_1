@extends('faculty.pages.facultymentees')
@section('page_heading','Search Mentee')
@section('section')

<?php
  for ($i=1; $i <=6 ; $i++) { 
    foreach ($departments as $department ) {
      if ($department->id==session('department_id')) {
        $dept = $department->dept_name;
        break;  
      }
    }
  }
?>
    <style>
        .xyz{
            max-height:400px;
            overflow-y:scroll;
        }  
        .abc {
            max-height: 700px;
            overflow-y: scroll;
        }
        .head {
            font-size: 35px;
        }
        th {
            position: sticky;
            top: -1px;
            background-color: white;
        }  
    </style>

    <div class="container-fluid">
        <div class="jumbotron">   
                               
            <strong class="head"> My Mentees</strong>
            <div class="pull-right">
            <a href="http://cms.com/staff/mymentees" class="btn btn-primary btn-md"><i class="fa fa-arrow-circle-left fa-lg" aria-hidden="true"></i></a>
            </div>
        </div>
    </div>

    <!--To find a list of mentees from all the mentees-->
    
    <div class="container-fluid">
        <div class="row">
            {{ Form::open(['action' => ['MenteeController@searchStudent'], 'method' => 'GET']) }}
            <div class="col-md-4">
              <select name="branch" id="branch" class="form-control" disabled placeholder="{{$dept}}">
                <option value="session('department_id')">{{$dept}}</option>
              </select>
            </div>      
            <div class="col-md-3">
                <select name="semester" id="semester" class="form-control" placeholder="Semester">
                <option value="" disabled selected>Semester</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option> 
                <option value="5">5</option>
                <option value="6">6</option>
                <option value="7">7</option>
                <option value="8">8</option>
                </select>
            </div>
            <div class="col-md-3">
                <select name="division" id="division" class="form-control" placeholder="Division">
                <option value="" disabled selected>Division</option>
                <option value="A">A</option>
                <option value="B">B</option>
                <option value="C">C</option>
                </select>
            </div>
            <div class="col-md-2">
                <div class="input-group custom-search-form">
                    <span class="input-group-btn">
                        <button class="btn btn-success" type="submit" name="Search">Find</button>
                    </span>
                </div>
            </div>
            {{ Form::close() }}
        </div>
        <div class="row">
            <br>
        </div>

        <div class="row">
            @if(count($mentees) > 0)
                
            <div class="container-fluid abc">
                <table class="table table-hover">
                    <thead>
                        <th>UID</th>
                        <th>Semester</th>
                        <th>Division</th>
                        <th>Roll No.</th>
                        <th>Name</th>
                        <th></th>
                    </thead>
                    <tbody>
                        @foreach($mentees as $mentee)
                            <tr>
                                <td>{{$mentee->uid}}</td>
                                <td>{{$mentee->semester}}</td>
                                <td>{{$mentee->division}}</td>
                                <td>{{$mentee->roll_no}}</td>
                                <td>{{$mentee->full_name}}</td>
                                <td><a class="btn btn-info btn-sm" href="/staff/mymentees/menteedetail/{{$mentee->uid}}">Meeting Info</a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>     
            </div>
            @else
                <br><br>
                <div class="text-center">
                    <h3>No students found</h3>
                </div>
            @endif
     </div>
    

    <!--Find results of the mentees present in the respective year, branch and division-->

    

    <style>
        .glyphicon.glyphicon-envelope 
        {
            font-size: 20px;
        }
       
    </style>

    <br>

@stop

