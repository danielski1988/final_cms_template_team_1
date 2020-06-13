@extends('faculty.layouts.dashboard')
@section('page_heading','Profile')
@section('section')
<br><br><br>
<div class="page-container">
<div class="profile">
    <div class="row">      <!--header--> 
    <br>
    <div class="col-lg-12 col-xs-12 name" style="margin:5px">
        <div class="row">
            <div class="col-md-9">
                <strong style="font-size:40px">{{$staff->first_name}} {{$staff->last_name}}</strong>
                {{--<strong style="font-size:40px"> [FirstName] [LastName] </strong>--}}
            </div>
            <div class="col-md-3">
                <br>
                <p class="text-primary ">Last Seen: {{$staff->last_active}}</p>
                {{--<p class="text-primary ">Last Seen: [LastSeen]</p>--}}
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <dt class="text-muted" style="font-size:20px">Employee Number</dt>
                <p>{{$staff->e_id}}</p>
                {{--<p> [EID] </p>--}}
                <dt class="text-muted" style="font-size:20px">Designation</dt>
                <p>{{$staff->designation}}</p>
                {{--<p> [Designtion] </p>--}}
                <dt class="text-muted" style="font-size:20px">Department</dt>
                <p>{{$department->dept_name}}</p>
                {{--<p> [Department Name] </p>--}}
            </div>
            <div class="col-md-4">
                {{--<div class="col-lg-3 col-xs-12 name  pull-left">--}}
                        <dt class="text-muted" style="font-size:20px">Date Of Joining</dt>
                         <p>{{$staff->doj}}</p> 
                        {{-- If the person has left, the field has a value != 0000-00-00 --}}
                        @if($staff->dol != '0000-00-00')
                            <dt class="text-muted" style="font-size:20px">Date Of Leaving</dt>
                            <p>{{$staff->dol}}</p> 
                        @endif
                        <dt class="text-muted" style="font-size:20px">Probation Time</dt>
                        <p>{{$staff->probation_start}} to {{$staff->probation_end}}</p> 
                        <dt class="text-muted" style="font-size:20px">VES Email</dt>
                        <p>{{$staff->email}}</p>
                
            </div>
            {{--<div class="col-md-3  col-xs-12 profilepic pull-right"  style="margin:5px">
                @if($pic !== NULL)
                    <img class="img-circle" src="data:image/png;base64,{{base64_encode($pic->image)}}" style="background-color:#e0e0e0;">
                @else
                    <img class="img-rounded" src="http://zoom.trus.co.id/plugintracker/images/pp-default.jpg" style="background-color:#e0e0e0;width:80%;height:80%">
                @endif
                <br>
                <!-- Need a fix, can't center -->
                <a class="btn col-md-9" href="{{ url ('/staff/uploadImage') }}">Edit Profile Picture</a>
                
            </div>--}}
        </div>
    </div> 
    </div>      <!--/.header-->
    <hr>
        <div class="row">
        <div class="col-lg-4  col-xs-12 name pull-left" >
            <strong class="text-danger" style="font-size:18px">Personal Details</strong></br></br>
            <dl>
                <dt>Mobile Number</dt>
                <dd>{{$staff->mobile}}</dd>
                <br>
                <dt>Address</dt>
                <dd>{{$staff->address}} - {{$staff->pincode}}</dd> 
                <br>
                @if($staff->landline != NULL)
                    <dt>Landline Number</dt>
                    <dd>{{$staff->landline}}</dd>
                    <br>
                @endif
                <dt>Gender</dt>
                @if($staff->gender == 'M')
                    <dd>MALE</dd>
                @elseif($staff->gender == 'F')
                    <dd>FEMALE</dd>
                @endif
                <br>
            </dl>
        </div>
        <div class="col-lg-6 col-lg-offset-1 col-xs-12 name pull-left">
            <dl>
            <br>
            <br>
                <dt>Date Of Birth</dt>
                <dd>{{date('d-M-Y',strtotime($staff->dob))}}</dd>
                <br>
                <dt>Concol Number</dt>
                <dd>{{$staff->concol}}</dd>
                <br>
                <dt>Aadhar Number</dt>
                <dd>{{$staff->aadhaar_id}}</dd>
                <br>
                <dt>PAN Number</dt>
                <dd>{{$staff->pancard}}</dd> 
            </dl>
        </div>
    </div>      <!--/.details-->
    <hr>
    <div class="row">
        <div class="col-lg-6  col-xs-12 name  pull-left">
            <strong class="text-danger" style="font-size:18px">Education Details</strong></br></br>
            <dl>
                <dt>Qualifications</dt>
                <dd>Your Latest Qualification</dd>
                <dd>Vivekanand Education Society Institute of Technology</dd>
                <dd>Year of Completion: 2010</dd>
                <dd>Your Earlier Qualification</dd>
                <dd>Vivekanand Education Society Institute of Technology</dd>
                <dd>Year of Completion: 2008</dd>
                <br>
                <dt>Expertise</dt>
                <dd>{{$staff->expertise}}</dd>
                <br>
                <dt>No.of Research Papers</dt>
                <dd>{{$staff->no_of_research_papers}}</dd> 
            </dl>
        </div>
    </div>      <!--/.details-->

</div>  <!--/.profile-->

</div>
@stop