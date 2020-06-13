@extends('faculty.layouts.dashboard')
@section('page_heading','Search Student')
@section('section')

    <div class="page-container">
        @if(count($students) > 0)
            @foreach($students as $student)
                <div class="row student-row">
                    <div class="col-sm-9">
                        <p class="details">UID #{{$student->uid}}</p>     
                        <p class="lead-details">{{$student->first_name}} {{$student->last_name}}</p>
                        <p class="details">{{$student->email_id}}</p>
                        <strong>Branch : </strong> {{$student->branch}}</p>
                        <p class="details"></p>
                        <div id="commentform">
                        {{-- {{ Form::open(['action' => ['CommentController@store'], 'method' => 'POST' ]) }} --}}
                            {{ Form::open(['method' => 'POST' ]) }} 
                            {{ Form::label('comment', 'Enter your remark here')}}
                            {{ Form::textarea('comment', '', ['class' => 'form-control article-ckediter'])}}
                            {{ Form::hidden('UID', $student->uid) }}
                            <br>
                            {{ Form::submit('Submit', array('class' => 'btn btn-primary')) }}
                            <br><br>
                        {{ Form::close() }}
                        </div>
                    </div>
                    
                    <div class="col-sm-3">
                        <button class="btn btn-success commentbtn">Make a Remark</button>
                    </div>
                </div>
                <hr>
            @endforeach
        @else
            <h3>No student found</h3>
        @endif
    </div>

<script>
$(document).ready(function() {
    $(".student-row .commentbtn").click(function(){
        console.log("clicked");
        $(this).parent().parent().find("#commentform").slideToggle();
    });
});
</script>

@stop

