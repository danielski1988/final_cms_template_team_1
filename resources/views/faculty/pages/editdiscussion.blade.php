@extends('faculty.layouts.dashboard')
@section('section')
<!-- Edit Form -->
@foreach($discussion as $d)
<div class="container-fluid">
    {!! Form::open (['action' => 'MenteeController@store', 'method' => 'POST']) !!}
        {{Form::hidden('id', $d->id )}}
        {{Form::hidden('m_id', session('e_id'))}}
        {{Form::hidden('s_id', $d->student_id )}}
        {{Form::hidden('created_by', session('e_id'))}}

        <div class="form-group">
            {{Form::label('date', 'Enter Date')}}
            {{Form::date('date', $d->date)}}                            
        </div>
 
        <div class="form-group">
            {{ Form::label('time', 'Enter Time')}}
            {{ Form::time('time', $d->time)}}
        </div>

        <div class="form-group">
            {{Form::label('query', 'Enter Discussion Title')}}
            {{Form::text('query', $d->query,['class' => 'form-control', 'placeholder' => 'Query Title'])}}
        </div>

        <div class="form-group">
            {{Form::label('description', 'Enter Description')}}
            {{Form::textarea('description', $d->description,['class' => 'form-control', 'placeholder' => 'Description'])}}
        </div>

        <div class="form-group">
            <a class="btn btn-default btn-close" href="{{ url('/staff/mymentees/menteedetail/'.$d->student_id) }} ">Back</a>                                            
            {{Form::submit('Save Changes', ['class' => 'btn btn-primary'])}}
        </div>
    {!! Form::close() !!}
</div>                
             


@endforeach
@endsection
