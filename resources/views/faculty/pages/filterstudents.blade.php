@extends('faculty.layouts.dashboard')
@section('page_heading','Assign Mentor')
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
  .head {
    font-size: 35px;
  }

  .dot {
    height: 30px;
    width: 35px;
    background-color: #bbb;
    border-radius: 50%;
    display: inline-block;
  }

  .label-lg {
    font-size: 16px;
  }

  .abc {
    max-height: 700px;
    overflow-y: scroll;
  }

  th {
    position: sticky;
    top: -1px;
    background-color: white;
  }
</style>

<div class="container-fluid">
  <div class="jumbotron">
    <div class="row">
      
      <strong class="head">Assign Mentors</strong>
      
      <address>Select the semester and division to proceed</address>
      
    </div>
  </div>
</div>
{!! Form::open(['action'=>'FilterStudentsController@store', 'method'=>'POST']) !!}

{{-- Sorting Students --}}
<div class="container-fluid">
  <div class="row">
    
      <div class="col-md-4">
        <select name="semester" id="semester" class="form-control" disabled placeholder="{{$dept}}">
          <option value='{{$dept}}'>{{$dept}}</option>
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
        {!! Form::submit('PROCEED', ['class'=>'btn btn-success btn-block']) !!}
      </div>
    
  </div>
  
</div>
@endsection