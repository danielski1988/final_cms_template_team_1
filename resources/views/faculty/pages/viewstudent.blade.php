{{-- Displays mentees of a particular mentor --}}
@extends('faculty.layouts.dashboard')
@section('page_heading','Students')
@section('section')

<style>
  .head{
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
</style>

@foreach ($mentor as $m)
  <div class="container-fluid">
    <div class="jumbotron">
      <strong class="head">Mentees of {{$m->first_name}} {{$m->last_name}}</strong>
      <div class="pull-right">
        <a href="/staff/mentors" class="btn btn-primary btn-md"><i class="fa fa-arrow-circle-left fa-lg" aria-hidden="true"></i></a>
      </div>
    </div> 
  </div>
@endforeach

<script src="https://www.kryogenix.org/code/browser/sorttable/sorttable.js"></script> 

<div class="container-fluid abc"> 
  <table class="table table-hover sortable-table">
    <thead>
    <tr>
      <th>id </th>
      <th>Semester</th>
      <th>Division</th>
      <th>Name</th>
      <th></th>
    </tr>
  </thead>
    @foreach ($mentor as $m)
      <?php
        $myMentorId=$m->e_id;
      ?>
    @endforeach
  <tbody>
    @foreach ($students as $student)
      @if ($student->mentor_id==$myMentorId)
        <tr>
          <td> {{$student->uid}} </td>
          <td>{{$student->semester}} </td>
          <td>{{$student->division}} </td>
          <td>{{$student->full_name}} </td>
          <td><a href="/staff/assignmentor/{{$student->uid}}" class="btn btn-default btn-sm">Info</a></td>
        </tr>
      @endif
    @endforeach
      </tbody>
  </table>
</div>

@endsection
