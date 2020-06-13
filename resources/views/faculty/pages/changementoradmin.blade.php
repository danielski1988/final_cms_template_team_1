@extends('faculty.layouts.dashboard')
@section('page_heading','Change Mentor Admin') 
@section('section')
    <div class="container-fluid">
        <div class="jumbotron">                      
            <strong class="head"> Change Mentor Administrators</strong>
        </div>
    </div>
    <style> 
        .to-scroll
        {
            max-height: 340px;
            overflow-y: scroll;
        }
        .depName{
            font-size: 21px;
        }
        .head {
            font-size: 35px;
        }
        .large-checkbox{
            width: 18px;
            height:18px;
        } 
    </style>
    
    {{ Form::open(array('action' => 'AssignMentorAdminController@store', 'method' => 'POST')) }}
    {{ csrf_field()}} 
<div class="container-fluid">
    <div class="row">  
        <div class="col-md-2 col-sm-2 col-lg-2 pull-left">                   
            <a class="btn btn-success btn-md" href="/staff/assignmentoradmin">Back</a>            
        </div>
        <div class="col-md-8 col-sm-8 col-lg-8">             
            <center><h3 class="depName"><strong>{{$depts->dept_name}}</strong></h3></center>     
        </div> 
        <div class="col-md-2 col-sm-2 col-lg-2 pull-right">                   
            {{ Form::submit('Save Changes', array('class' => 'btn btn-primary btn-md')) }}            
        </div> 
    </div> 

    <br>   

    <div class="to-scroll" style="width:100%">
        <div class="row" style="width:100%">
        {{ Form::hidden('dep',$depts->id) }}
            @foreach($allstaff as $onestaff)
                @if($onestaff->department_id == $depts->id)    
                <div class="col-sm-6 col-md-6 col-lg-6">                            
                    <span class="conatiner-fluid" style="display:inline-block;  position:relative;">                        
                            <?php $flag = 0; ?>                                  
                            @foreach($mentoradmins as $mentoradmin)
                                @if($onestaff->e_id == $mentoradmin->e_id)                                                
                                    <?php $flag = 1; ?>
                                @endif
                            @endforeach
                            
                            <div class="input-group">
                                <span class="input-group-addon">
                                    @if($flag == 1)
                                        {{-- {{ Form::checkbox('selected_students[]', $student->uid, false, ['class' => 'large-checkbox']) }} --}}
                                        {{ Form::checkbox('ma[]', $onestaff->e_id, true, ['class' => 'large-checkbox']) }}
                                    @else                                            
                                        {{ Form::checkbox('ma[]', $onestaff->e_id, false, ['class' => 'large-checkbox']) }}
                                    @endif                                   
                                </span> 
                                <div class="form-control">
                                    &nbsp;{{$onestaff->first_name}} {{$onestaff->last_name}}
                                </div>                               
                            </div>                                
                    </span> 
                </div>
                @endif
            @endforeach
        </div>
    </div>
</div>    
    {{ Form::close() }}
@stop
