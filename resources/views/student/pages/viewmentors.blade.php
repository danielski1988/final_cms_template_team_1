@extends('student.layouts.dashboard')
{{-- I'm Sreekesh Iyer --}}
{{--I am a Student--}}
@section('section')

    
    <div class="panel panel-primary">
        <div class="panel-heading">Mentor Info</div>
        <div class="panel-body">
            <?php $m_id = 0 ?>
            <?php $var = session('uid') ?>
            @foreach($mentordata as $md)
                <?php $m_id = $md->e_id ?>
                <b>Name : </b>{{$md->first_name}} {{$md->last_name}}
                <b>E-mail : </b> <a href="mailto:{{$md->email}}">{{$md->email}}</a>
            @endforeach
        </div>
    </div>
    
    <hr noshade>    
    <div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModal2Label" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModal2Label">Enter log for previous meeting with mentor</h5>                        
                </div>
                {!! Form::open (['action' => 'StudentsController@store', 'method' => 'POST']) !!}
                <div class="modal-body">
                    {{Form::hidden('s_id', $var )}}
                    {{Form::hidden('m_id', $m_id)}}
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
                    {{Form::hidden('created_by', session('uid'))}}
                    {{Form::submit('Submit', ['class' => 'btn btn-primary'])}}
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class = "col-md-2"><p class="lead"><strong>Meeting Log</strong></p></div>
        <div class = "col-md-3" style="text-align: right">Search by Date</div>
        <div class = "col-md-5"><input type="date" class="form-control" id="myInput" onkeyup="myFunction()" onclick="myFunction()"></div>
        <div class = "col-md-2"><button type="button" class="btn btn-primary pull-right " data-toggle="modal" data-target="#exampleModal2">Enter Meeting Log</button></div>
    </div>
    <?php $count=0; ?>
    @foreach($mentorlogs as $md)
        <?php $count++; ?>
    @endforeach
    @if($count == 0)
    <br><br>
        <center><big><b>No Meeting Logs</b></big></center>
    @else
    <div class="container-fluid abc">
        <table class="sortable table" id="myTable">
            <thead>
                <th style="width:10%">Date</th>
                <th style="width:10%">Time</th>
                <th style="width:15%">Added By</th>
                <th style="width:35%">Discussions</th>
                <th style="width:15%"></th>
                {{ csrf_field() }}
            </thead>
            <tbody>
                @foreach($mentorlogs as $md)
                    @if(($md->created_by == session('uid')) OR ($md->created_by == $m_id))
                        <tr>
                            <td>{{$md->date}}</td>
                            <td>{{$md->time}}</td>
                            <td>
                                @if($md->created_by == session('uid'))
                                    Student
                                @elseif($md->created_by == $m_id)
                                    Mentor
                                @endif
                            </td>
                        <td>
                            <dl>
                                <dt>
                                    {{$md->query}}
                                </dt>
                                <dd>
                                    <div class="well well-sm">
                                       
                                            <a class="read-more-show hide" href="#">Read Description</a> <span class="read-more-content">
                                            {{$md->description}}
                                            <a class="read-more-hide hide" href="#">Read Less</a></span>
                                       
                                    </div>
                                </dd>
                            </dl>
                        </td>                        
                        <td>
                            <div class="row">
                                @if($md->created_by == session('uid'))
                                <div class="col-md-5">
                                    <a class="btn btn-warning" href="mentor/{{$md->id}}/edit">Edit</a>  
                                </div>
                                <div class="col-md-6">
                                    {!!Form::open(['action' => ['StudentsController@destroy',$md->id ], 'method' => 'POST']) !!}
                                        {{Form::hidden('_method', 'DELETE')}}                                                    
                                        {{Form::submit('Delete',['class' => 'btn btn-danger'])}}                                                   
                                    {!! Form::close() !!}
                                </div>
                                
                                @endif
                            </div>
                        </td>
                    </tr>
                    
                    @endif

                @endforeach
            </tbody>
        </table>
    </div>
    @endif
    
    <style>
        #myInput {
            background-image: url('/css/searchicon.png'); /* Add a search icon to input */
            background-position: 10px 12px; /* Position the search icon */
            background-repeat: no-repeat; /* Do not repeat the icon image */
            width: 53%; /*  width */
            font-size: 16px; /* Increase font-size */
            padding: 10px 15px 10px 40px; /* Add some padding */
            border: 1px solid #ddd; /* Add a grey border */
            margin-bottom: 10px; /* Add some space below the input */
        }
        .well{
            background-color: rgb(231, 253, 255) !important;
        }
        
        
        .abc
        {
            max-height: 450px;
            overflow-y: scroll;
        }
        tbody{
            table-layout: fixed;
        }
        table{
            table-layout: fixed;
        }
        th {
            position: sticky;
            top:0px;
            background-color: white;
        }
    </style>
    
    <script src="https://www.kryogenix.org/code/browser/sorttable/sorttable.js"></script>
    
    <script>
        
        function myFunction() {
        // Declare variables
            var input, filter, table, tr, td, i, txtValue;
            input = document.getElementById("myInput");
            filter = input.value.toUpperCase();
            table = document.getElementById("myTable");
            tr = table.getElementsByTagName("tr");

        // Loop through all table rows, and hide those who don't match the search query
        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[0];
            if (td) {
            txtValue = td.textContent || td.innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                tr[i].style.display = "";
            } else {
                tr[i].style.display = "none";
            }
            }
        }
        }

        // Hide the extra content initially, using JS so that if JS is disabled, no problemo:
        $('.read-more-content').addClass('hide')
        $('.read-more-show, .read-more-hide').removeClass('hide')

        // Set up the toggle effect:
        $('.read-more-show').on('click', function(e) {
            $(this).next('.read-more-content').removeClass('hide');
            $(this).addClass('hide');
            e.preventDefault();
        });

        $('.read-more-hide').on('click', function(e) {
            var p = $(this).parent('.read-more-content');
            p.addClass('hide');
            p.prev('.read-more-show').removeClass('hide'); // Hide only the preceding "Read More"
            e.preventDefault();
        });    
        
        
        // <div class="col-md-1">
        //                             <div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="exampleModal2Label" aria-hidden="true">
        //                                 <div class="modal-dialog" role="document">
        //                                     <div class="modal-content">
        //                                         <div class="modal-header">
        //                                             <h5 class="modal-title" id="exampleModal2Label">Are you sure you want to delete the following discussion log?</h5>
        //                                         </div>
                                                
        //                                     </div>
        //                                 </div>
        //                             </div>
        //                         </div>
            
    </script>

@endsection