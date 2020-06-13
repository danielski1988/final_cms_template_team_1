@extends('faculty.layouts.dashboard')
@section('page_heading','View Mentor Admins') 
@section('section')

<div class="container-fluid">
  <div class="jumbotron">                      
      <strong class="head"> Mentor Administrators</strong>
  </div>
</div>
<style>
  .abc
  {
      max-height: 450px;
      overflow-y: scroll;
  }
  .info
  {
    font-size: 16px;
  }
  .head {
    font-size: 35px;
  } 
</style>

<div class="container-fluid">
<div class="table-responsive">  
  <table class="table table-hover ">
    <thead> 
      <th class="info">Department</th>
      <th class="info">Mentor Administrator/s</th>
      <th class="info"></th>
    </thead>
    <tbody >   
      @foreach($depts as $dept) 
        <?php
          $count=0;
        ?>
        @if($dept->id <= 6)
          @foreach($mas as $ma)
            @if($ma->department_id == $dept->id)
              <?php 
                $count=$count+1 ;
              ?>                
            @endif
          @endforeach
          @if($count == 0)
            <tr>    
                <th scope="row">{{$dept->dept_name}}</th>               
                <td><span class="label label-danger">Not Assigned</span></td>              
                <td><center><a class="btn btn-danger btn-rounded btn-md " href="assignmentoradmin/{{$dept->id}}">Assign</a></center></td>              
            </tr>
          @else
              <tr>    
                <th scope="row">{{$dept->dept_name}}</th>               
                  <td>
                    <ul class="list-unstyled">
                      @foreach($mas as $ma)
                        @if($ma->department_id == $dept->id)
                          <li>
                            {{$ma->first_name}} {{$ma->last_name}}
                          </li>                        
                        @endif
                      @endforeach
                    </ul>
                  </td>              
                <td><center><a class="btn btn-primary btn-rounded btn-md " href="assignmentoradmin/{{$dept->id}}">Change</a></center></td>              
              </tr>
            @endif
        @endif
      @endforeach
    </tbody>
  </table>
</div>
</div>
<br>
@stop
