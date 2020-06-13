@extends('faculty.layouts.dashboard')
@section('page_heading','Student Information')
@section('section')

<style>

  .table th {
    text-align: left;
  }

  .table {
    text-align: unset;
    border-radius: 5px;
    width: 50%;
    margin: 0px auto;
    float: none;
  }

</style>
<div class="container-fluid">
  <center><h3><strong>{{$studentInfo->first_name}} {{$studentInfo->last_name}}</strong></h3></center>
  <br><br>
  <div class="table-responsive">
    <table class="table table-hover">
      <tr>
        <th>uid</th>
        <td></td>
        <td>{{$studentInfo->uid}}</td>
      </tr>
      <tr>
        <th>email</th>
        <td></td>
        <td>{{$studentInfo->email_id}}</td>
      </tr>
      <tr>
        <th>Name</th>
        <td></td>
        <td>{{$studentInfo->first_name}} {{$studentInfo->mid_name}} {{$studentInfo->last_name}}</td>
      </tr>
      <tr>
        <th>Gender</th>
        <td></td>
        @if ($studentInfo->gender == 1)
          <td>Male</td>
        @else
          <td>Female</td>
        @endif
      </tr>
      <tr>
        <th>Type of admission</th>
        <td></td>
        <td>{{$studentInfo->type_of_admission}}</td>
      </tr>
      <tr>
        <th>Admission Year</th>
        <td></td>
        <td>{{$studentInfo->admission_year}}</td>
      </tr>
      <tr>
        <th>Branch</th>
        <td></td>
        <td>{{$studentInfo->branch}}</td>
      </tr>
      <tr>
        <th>Mobile</th>
        <td></td>
        <td>{{$studentInfo->mobile}}</td>
      </tr>
      <tr>
        <th>Address</th>
        <td></td>
        <td>{{$studentInfo->permanent_address}}</td>
      </tr>
      <tr>
        <th>Changed branch</th>
        <td></td>
        @if ($studentInfo->gender == 1)
          <td>YES</td>
        @else
          <td>NO</td>
        @endif
      </tr>
      <tr>
    </table>
  </div>

@endsection