@extends('faculty.layouts.dashboard')
@section('page_heading','Assignment')
@section('section')
{{-- messages --}}
@include('faculty.pages.messages')
{{-- -------- --}}
<style>
  .head{
    font-size: 40px;
  }
  .abc {
    max-height: 600px;
    overflow-y: scroll;
  }
</style>


 {!! Form::open(['action'=>'ToAssignController@store', 'method'=>'POST']) !!}
<div class="container-fluid">
  <div class="jumbotron">
    <div class="row">
      {{-- <div> --}}
        <strong class="head">Choose Mentor</strong>
      {{-- </div> --}}
      <div class="pull-right">
        {!! Form::submit('Submit', ['class'=>'btn btn-primary btn-lg']) !!}
      </div>
    </div>
  </div>
</div>
@foreach ($selectedStudents as $m)
  {!! Form::hidden('selected_student[]', $m) !!}
@endforeach

{{-- To redirect to previous page --}}
{{  Form::hidden('url',URL::previous())  }}

<div class="container abc" style="width: 100%">
  {{-- Displaying the table and option for selectiong a mentor --}}
    @foreach ($mentors as $mentor)
    @if ($mentor->department_id == session('department_id'))
      @if ($mentor->type==1)
      <span style="display: inline-block; width:33%">
        <div class="well well-sm">
          {!! Form::radio('mentor_id', $mentor->e_id) !!}
          &nbsp;
          {{$mentor->first_name}}
          {{$mentor->last_name}}
          {{-- Number of mentees assigned --}}
        </div>
      </span>
      @endif
    @endif
  @endforeach
</div>

{!! Form::close() !!}

@endsection 