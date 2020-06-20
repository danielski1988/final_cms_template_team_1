
{{-- Page for selectiong students for assignment of mentor --}}
@extends('faculty.layouts.dashboard')
@section('page_heading','Assign Mentor')
@section('section')

<style>
  .head {
    font-size: 35px;
  } 

  .abc {
    max-height: 72vh;
    overflow: auto;
  }

  th {
    position: sticky;
    top: -1px;
    background-color: white;
  }
  .large-checkbox{
    width: 18px;
    height:18px;
  }
</style>

{!! Form::open(['action'=>'AssignMentorsController@store', 'method'=>'POST']) !!}
{{-- Heading --}}
<div class="container-fluid">
  <div class="jumbotron">
    <div class="row">
      <strong class="head">Assign Mentors</strong>
      <div class="pull-right">
        <a href="/staff/assignmentor" class="btn btn-primary btn-md"><i class="fa fa-arrow-circle-left fa-lg" aria-hidden="true"></i></a>
        &nbsp;&nbsp;&nbsp;
        {{-- Assign / Edit button --}}
        {{-- src => toassign.blade.php --}}
        <button type="submit" class="btn btn-success btn-md">Assign / Edit</button>
      </div>
    </div>
  </div>
</div>

<script src="https://www.kryogenix.org/code/browser/sorttable/sorttable.js"></script> 

{{-- Table Layout --}}

<div class="container-fluid abc" >
  <table class="table table-hover sortable-table">
    <thead>
      <tr>
        <th></th>
        <th><b> Unique id </b></th>
        <th></th>
        <th><b> Sem </b> </th>
        <th><b> Division </b> </th>
        <th><b> Roll no. </b></th>
        <th><b> Name </b></th>
        {{-- <th><b> Mentors </b>&nbsp;{!! Form::checkbox('notassigned[]', 1, false, ['class' => 'large-checkbox']) !!}</th> --}}
        <th><b>Mentor</b> </th>
      </tr>
    </thead>
    <tbody>
      @foreach ($students as $student)
      {{-- Storing Names of Mentors --}}
        @foreach ($mentors as $mentor)
          @if(($mentor->e_id) == ($student->mentor_id))
            <?php
              $mentorFirstName = $mentor->first_name;
              $mentorLastName = $mentor->last_name;
              $mentorShortForm = $mentor->short_form;
            ?>
          @endif
        @endforeach

      {{-- Displaying --}} 
      <tr>
        {{-- Store array of 'uid' of selected students --}}
        <td>{!! Form::checkbox('selected_students[]', $student->uid, false, ['class' => 'large-checkbox']) !!} </td>
        <td> {{$student->uid}} </td>
        <td><a href="/staff/assignmentor/{{$student->uid}}" class="btn btn-default btn-sm">Info</a></td>
        <td>{{$student->semester}}  </td>
        <td> {{$student->division}} </td>
        <td> {{$student->roll_no}} </td>
        <td> {{$student->first_name}}&nbsp;{{$student->last_name}} </td>

        {{-- Mentor's name --}}
        <td>
          <div class="row">
            @if($student->mentor_id)
            <div>
              <strong><b>{{$mentorFirstName}}&nbsp;{{$mentorLastName}}</b></strong>
            </div>
          </div>
          @else
          <div class="label label-danger label-lg">
            <strong>Not Assigned !</strong>
          </div>
          @endif
        </td>
        {{--  --}}
      </tr>
      @endforeach
    </tbody>
  </table>
</div>

{!! Form::close() !!}

@endsection