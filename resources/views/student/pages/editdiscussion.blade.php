@extends('student.layouts.dashboard')
@section('section')
<!-- Edit Form -->
@foreach($discussion as $d)
<div class="container-fluid">
    {!! Form::open (['action' => 'StudentsController@store', 'method' => 'POST']) !!}
        {{Form::hidden('id', $d->id )}}
        {{Form::hidden('s_id', session('uid') )}}
        @foreach($student as $s)
        {{Form::hidden('m_id', $s->mentor_id)}}
        @endforeach
        {{Form::hidden('created_by', session('uid'))}}

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
            <a class="btn btn-default btn-close" href="{{ url('/student/mentor') }} ">Cancel</a>                                            
            {{Form::submit('Save Changes', ['class' => 'btn btn-primary'])}}
        </div>
    {!! Form::close() !!}
</div>                
             


@endforeach
@endsection
