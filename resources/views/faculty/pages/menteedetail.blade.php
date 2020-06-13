@extends('faculty.layouts.dashboard')
@section('page_heading','Mentee Detail')
@section('section')

    <div class="container-fluid">
        <div class="jumbotron">    
            <div class="row">
                <div class="col-md-10">              
                    <strong class="head"> Meeting Details</strong>
                </div>
                <div class="col-md-2">
                        <a type="button" href="javascript:history.back()" class="btn btn-primary btn-md" ><i class="fa fa-arrow-circle-left fa-lg" aria-hidden="true"></i></a>
                        <button href="mailto:{{$detail->email_id}}" class="btn btn-primary btn-md"><i class="fa fa-envelope fa-lg"></i></button>
                </div>       
            </div>
            <address>
                {{$detail->full_name}}
            </address>
        </div>
    </div>



    <!--To make a discussion log-->
    <script src="https://www.kryogenix.org/code/browser/sorttable/sorttable.js"></script>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-6 form-inline">Search by dates:&nbsp;&nbsp;<input class="form-control" type="date" id="myInput" onkeyup="myFunction()" onclick="myFunction()"></div>
        <div class="col-md-6">
            <button type="button" class="btn btn-success pull-right" data-toggle="modal" data-target="#exampleModal2"><i class="fa fa-plus fa-lg" aria-hidden="true"></i></button>
        </div>  
    </div>

    <div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModal2Label" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModal2Label">Enter log for previous meeting with mentor</h5>
                </div>
                {!! Form::open (['action' => 'MenteeController@store', 'method' => 'POST']) !!}
                    <div class="modal-body">
                        @include('faculty.pages.discussion')
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        {{Form::submit('Submit', ['class' => 'btn btn-success'])}}
                    </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>

    <script>
        $('#datetimepicker').datetimepicker({format: 'yyyy-mm-dd'});
    </script>

    <!--To show the meeting info-->

    <style>
        .abc{
            max-height:400px;
            overflow-y:scroll;
        }  
        .hide{
            display: none;
        }
        .head {
            font-size: 25px;
        }
        
        #myInput {
            background-image: url('/css/searchicon.png'); /* Add a search icon to input */
            background-position: 10px 20px; /* Position the search icon */
            background-repeat: no-repeat; /* Do not repeat the icon image */
            width: 70%; /* 1/5 th width */
            font-size: 16px; /* Increase font-size */
            padding: 10px 15px 10px 40px; /* Add some padding */
            border: 1px solid #ddd; /* Add a grey border */
            margin-bottom: 10px; /* Add some space below the input */
        }
        
        .well{
            background-color: rgb(231, 253, 255) !important;
        }
    </style>

    
    <div class="abc">
        <table class="table table-hover sortable-table" id="myTable">
        <thead>
                <th style="width:10%">Date</th>
                <th style="width:10%">Time</th>
                <th style="width:15%">Added By</th>
                <th style="width:45%">Discussions</th>
                <th style="width:15%"></th>            
        </thead>
        <tbody>
                @foreach($log as $l)
                @if($l->e_id == session('e_id') and $l->student_id == $detail->uid)
                    <tr>
                        <td>{{$l->date}}</td>
                        <td>{{$l->time}}</td>
                        @if($l->created_by == session('e_id'))
                            <td>{{session('first_name')}} {{session('last_name')}} (Mentor)</td>
                        @else
                            <td>{{$detail->full_name}} (Student)</td>
                        @endif
                        <td>
                            <dl>
                                <dt>
                                    {{$l->query}}
                                </dt>
                                <dd>
                                    <div class="well well-sm">
                                        <p>
                                            <a class="read-more-show hide" href="#">Read Description</a><span class="read-more-content">
                                                {{$l->description}}
                                            <a class="read-more-hide hide" href="#">Read Less</a></span> 
                                        </p>
                                    </div>
                                </dd>
                            </dl>
                        </td>
                        <td> 
                            <!--To edit a discussion log-->
                            <div  style="text-align: end">
                               
                                <a class="btn btn-warning" href="{{$l->id}}/edit"><i class="fa fa-pencil" aria-hidden="true"></i></a>  
                                
                                
                                {!!Form::open(['action' => ['MenteeController@destroy', $l->id], 'method' => 'POST']) !!}
                                {{Form::hidden('_method', 'DELETE')}} 
                            
                                
                                    {{-- {{Form::submit('Delete',['class' => 'btn btn-danger'])}}    
                                                                     --}}
                                    <button type="submit" class="btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></button>
                                {!! Form::close() !!}
                                
                                
                            </div>
                            
                        </td>
                    </tr>
                @endif
                @endforeach
            </tbody>
        </table>
    </div>
</div>
    <script>
        $('#edit').on('show.bs.modal',function(event){
            var button=$(event.relatedTarget)
            var title=button.data('mytitle')
            var description=button.data('mydescription')
            var date=button.data('mydate')
            var time=button.data('mytime')
            var id=button.data('qid')
            var modal=$(this)
            modal.find('.modal-body #query').val(title);
            modal.find('.modal-body #description').val(description);
            modal.find('.modal-body #date').val(date);
            modal.find('.modal-body #time').val(time);
            modal.find('.modal-body #id').val(id);
        })
    </script>

    <script>      
        function myFunction() {
        // Declare variables
            var input, filter, table, tr, td, i, txtValue;
            input = document.getElementById("myInput");
            filter = input.value.toUpperCase();
            table = document.getElementById("myTable");
            tr = table.getElementsByTagName("tr");

        // Loop through all table rows, and hide those who don't match the search query
            for (i = 0; i < tr.length; i++) 
            {
                td = tr[i].getElementsByTagName("td")[0];
                if (td) 
                {
                    txtValue = td.textContent || td.innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1) 
                    {
                        tr[i].style.display = "";
                    } 
                    else 
                    {
                        tr[i].style.display = "none";
                    }
                }
            }
        }
    </script>

    <script src="https://www.kryogenix.org/code/browser/sorttable/sorttable.js"></script>

    <script>
        // Hide the extra content initially, using JS so that if JS is disabled, no problem:
        $('.read-more-content').addClass('hide')
        $('.read-more-show, .read-more-hide').removeClass('hide')

        // Set up the toggle effect:
        $('.read-more-show').on('click', function(e){
            $(this).next('.read-more-content').removeClass('hide');
            $(this).addClass('hide');
            e.preventDefault();
        });
        
        // Changes contributed by @diego-rzg
        $('.read-more-hide').on('click', function(e) {
            var p = $(this).parent('.read-more-content');
            p.addClass('hide');
            p.prev('.read-more-show').removeClass('hide'); // Hide only the preceding "Read More"
            e.preventDefault();
        });
    </script>

{{-- <div class="col-md-1">
    <div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="exampleModal2Label" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModal2Label">Are you sure you want to delete the following discussion log?</h5>
                </div>
                {!!Form::open(['action' => ['MenteeController@destroy', $l->id], 'method' => 'POST']) !!}
                    {{Form::hidden('_method', 'DELETE')}} 
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        {{Form::submit('Delete',['class' => 'btn btn-danger'])}}
                    </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div> --}}
@stop