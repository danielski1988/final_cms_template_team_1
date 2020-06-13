@extends('faculty.layouts.dashboard')
@section('page_heading','Mentors Table')
@section('section')

{{-- Finding the department --}}
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

<script src="https://www.kryogenix.org/code/browser/sorttable/sorttable.js"></script>

<style>
  .head{
    font-size: 35px;
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
    <strong class="head">Mentors of {{$dept}}</strong>
  </div>
</div>

    {{-- Table Layout --}}
<div class="container-fluid">
  <div class="container abc" style="width: 100%">
    <table class="table table-hover sortable-table">
      <thead>
      <tr>
        <th> Employee id </th>
        <th> Name </th>
        <th>Number of Mentees</th>
        <th> Mentees </th>
      </tr>
    </thead>
      {{-- -------------------- Mentors ------------------- --}}
      <tbody>
      @foreach ($mentors as $mentor)
        @if ($mentor -> department_id == session('department_id'))
          <tr>
            <td><a href="/staff/profile/{{$mentor->e_id}}">{{$mentor->e_id}}</a></td>
            <td>{{$mentor->first_name}} {{$mentor->last_name}}</td>
            <td>
              <?php $count=0; ?>
              @foreach($students as $s)
                @if($s->mentor_id == $mentor->e_id)
                  <?php $count++; ?>
                @endif
              @endforeach
              {{$count}}
            </td>
            <td>
              <a href="viewstudent\{{$mentor->e_id}}" class="btn btn-primary btn-md">View Mentees</a>
            </td>
          </tr>
        @endif
      @endforeach
        </tbody>
      {{-- ------------------------------------------------- --}}
    </table>
  </div>
</div>


@endsection