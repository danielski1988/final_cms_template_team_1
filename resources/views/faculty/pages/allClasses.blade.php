@extends('faculty.layouts.dashboard')
@section('page_heading','Search Student')
@section('section')
<style>
    .abc
    {
        max-height: 450px;
        overflow-y: scroll;
    }
    th {
        position: sticky;
        top:0px;
        background-color:white;
    }
</style>
<div class="well well-sm">
    <h3>All Student Allottments</h3>
</div>
<?php $i=1; ?>
<div class="abc">
<table class="table">
    <thead>
        <th>Date</th>
        <th>Time</th>
        <th>Added By</th>
        <th>Discussions</th>
        <th></th>
    </thead>
    <tbody>
        @while($i<=100)            
            <tr>
                <td>Date{{$i}}</td>
                <td>Time{{$i}}</td>
                <td>Name{{$i}}</td>
                <td>
                    <dl>
                        <dt>Title{{$i}}</dt>
                        <dd>
                            <div class="well well-sm">
                                <p>
                                    <a class="read-more-show hide" href="#">Read Description</a> <span class="read-more-content">                                    
                                    <a class="read-more-hide hide" href="#">Read Less</a></span>
                                </p>
                            </div>
                        </dd>
                    </dl>
                </td>                        
                <td>
                    <div class="btn-group" role="group" aria-label="Basic example">
                        {!!Form::open(['method'=>'POST', 'class' => 'pull-right'])!!}
                            {{Form::hidden('_method','DELETE')}}
                            {{Form::submit('Delete', ['class' => 'btn btn-danger btn-sm'])}}                                           
                        {!!Form::close()!!}
                        &nbsp;
                        <button type="button" class="btn btn-warning btn-sm" data-mytitle="Title{{$i}}" data-mydescription="Description{{$i}}" data-mydate="Date{{$i}}" data-mytime="Time{{$i}}"data-qid="id{{$i}}" data-toggle="modal" data-target="#edit">Edit</button>
                    </div>
                </td>
            </tr>
           
            
            <div class="col-md-1">
                <div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="exampleModal3Label" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModal3Label">To edit the log for previous meeting with mentor</h5>
                            </div>
                            {!! Form::open () !!}
                                {{method_field('patch')}}
                                {{Form::hidden('id', 1 )}} 
                                <div class="modal-body">
                                    {{Form::hidden('s_id', 1 )}}
                                    {{Form::hidden('m_id', session('e_id'))}}
                                    <div class="form-group">
                                        {{Form::label('date', 'Enter Date')}}
                                        {{Form::date('date', \Carbon\Carbon::now())}}
                                    </div>
                                    <div class="form-group">
                                        {{ Form::label('time', 'Enter Time')}}
                                        {{ Form::time('time', Carbon\Carbon::now()->format('H:i'))}}
                                    </div>
                                    <div class="form-group">
                                        {{Form::label('query', 'Enter Discussion Title')}}
                                        {{Form::text('query', '',['class' => 'form-control', 'placeholder' => 'Query Title'])}}
                                    </div>
                                    <div class="form-group">
                                        {{Form::label('description', 'Enter Description')}}
                                        {{Form::textarea('description', '',['class' => 'form-control', 'placeholder' => 'Description'])}}
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                    {{Form::submit('Save Changes', ['class' => 'btn btn-primary'])}}
                                </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
            <?php $i++ ?>
        @endwhile
    </tbody>
</table>
</div>


<div class="abc">
    <table class="table">
        <thead>
            <th>term</th>
            <th>div</th>
            <th>uid</th>
            <th>roll</th>
            <th>batch</th>
            <th>email</th>        
            <th>name</th>
            <th>adnYr</th>
            <th>branch</th>
            <th>sem</th>
        </thead>
        <tbody>
            @foreach($all as $a)
            <tr>
                <td>{{$a->term_id}}</td>
                <td>{{$a->division}}</td>
                <td>{{$a->uid}}</td>
                <td>{{$a->roll_no}}
                <td>{{$a->batch}}</td>
                <td>{{$a->email_id}}</td>            
                <td>{{$a->full_name}}</td>
                <td>{{$a->admission_year}}</td>
                <td>{{$a->branch}}</td>
                <td>{{$a->semester}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@stop