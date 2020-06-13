@extends('faculty.layouts.dashboard')
@section('page_heading','Attendance Test UI')
@section('section')

<div class="page-container">
    <div class="row">
    @for($i = 1; $i<80; $i+=2)
        <div class="attendance-card col-xs-3 col-sm-2 col-md-1 btn-success">
            <span>P</span>
            <div class="roll-no text-center">{{$i}}</div>
            <div class="text-center name">Kaushal</div>
        </div>

        <div class="attendance-card col-xs-3 col-sm-2 col-md-1 btn-danger">
            <span>A</span>
            <div class="roll-no text-center">{{$i+1}}</div>
            <div class="text-center name">Kaushal</div>
        </div>
    @endfor
    </div>

</div>

@stop