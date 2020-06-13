@extends('faculty.layouts.dashboard')
@section('page_heading','Mentors Information')
@section('section')
<div class="page-container">
<div class="profile">
    <div class="row">      
    <br>
    <div class="col-lg-12 col-xs-12 name" style="margin:5px">
        <div class="row">
            <div class="col-md-9">
                <strong style="font-size:40px">{{$mentorInfo->first_name}} {{$mentorInfo->last_name}}</strong>
            </div>
            <div class="col-md-3">
                <br>
                <p class="text-primary ">Last Seen: {{$mentorInfo->last_active}}</p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <dt class="text-muted" style="font-size:20px">Employee Number</dt>
                <p>{{$mentorInfo->e_id}}</p>
                <dt class="text-muted" style="font-size:20px">Designation</dt>
                <p>{{$mentorInfo->designation}}</p>
                <dt class="text-muted" style="font-size:20px">Department</dt>
                <p>{{$mentorInfo->department_id}}</p>
            </div>
            <div class="col-md-4">
                        <dt class="text-muted" style="font-size:20px">Date Of Joining</dt>
                          <p>{{$mentorInfo->doj}}</p> 
                        @if($mentorInfo->dol != '0000-00-00')
                            <dt class="text-muted" style="font-size:20px">Date Of Leaving</dt>
                            <p>{{$mentorInfo->dol}}</p> 
                        @endif
                        <dt class="text-muted" style="font-size:20px">Probation Time</dt>
                        <p>{{$mentorInfo->probation_start}} to {{$mentorInfo->probation_end}}</p> 
                        <dt class="text-muted" style="font-size:20px">VES Email</dt>
                        <p>{{$mentorInfo->email}}</p>
                
            </div>
            {{--
            <div class="col-md-3  col-xs-12 profilepic pull-right"  style="margin:5px">
                @if($pic !== NULL)
                    <img class="img-circle" src="data:image/png;base64,{{base64_encode($pic->image)}}" style="background-color:#e0e0e0;">
                @else
                    <img class="img-rounded" src="http://zoom.trus.co.id/plugintracker/images/pp-default.jpg" style="background-color:#e0e0e0;width:80%;height:80%">
                @endif
                <br>
                <!-- Need a fix, can't center -->
                <a class="btn col-md-9" href="{{ url ('/staff/uploadImage') }}">Edit Profile Picture</a>
                
            </div>
            --}}
        </div>
    </div> 
    </div>     
    <hr>
        <div class="row">
        <div class="col-lg-4  col-xs-12 name pull-left" >
            <strong class="text-danger" style="font-size:18px">Personal Details</strong></br></br>
            <dl>
                <dt>Mobile Number</dt>
                <dd>{{$mentorInfo->mobile}}</dd>
                <br>
                <dt>Address</dt>
                <dd>{{$mentorInfo->address}} - {{$mentorInfo->pincode}}</dd> 
                <br>
                @if($mentorInfo->landline != NULL)
                    <dt>Landline Number</dt>
                    <dd>{{$mentorInfo->landline}}</dd>
                    <br>
                @endif
                <dt>Gender</dt>
                @if($mentorInfo->gender == 'M')
                    <dd>MALE</dd>
                @elseif($mentorInfo->gender == 'F')
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
                <dd>{{date('d-M-Y',strtotime($mentorInfo->dob))}}</dd>
                <br>
                <dt>Concol Number</dt>
                <dd>{{$mentorInfo->concol}}</dd>
                <br>
                <dt>Aadhar Number</dt>
                <dd>{{$mentorInfo->aadhaar_id}}</dd>
                <br>
                <dt>PAN Number</dt>
                <dd>{{$mentorInfo->pancard}}</dd> 
            </dl>
        </div>
    </div>      
    <hr>
    <div class="row">
        <div class="col-lg-6  col-xs-12 name  pull-left">
            <strong class="text-danger" style="font-size:18px">Education Details</strong><br><br>
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
                <dd>{{$mentorInfo->expertise}}</dd>
                <br>
                <dt>No.of Research Papers</dt>
                <dd>{{$mentorInfo->no_of_research_papers}}</dd> 
            </dl>
        </div>
    </div>      
  </div>
</div>  
</div>

@stop

{{--<style>

  .table th {
    text-align: left;
  }

  .table {
    text-align: unset;
    border-radius: 5px;
    width: 50%;
    margin: 0px auto;
    float: none;
  }

</style>
<div class="container-fluid">
  <center><h3><strong>{{$mentorInfo->first_name}} {{$mentorInfo->last_name}}</strong></h3></center>
  <br><br>
  <div class="table-responsive">
    <table class="table table-hover">
      <tr>
        <th>id</th>
        <td></td>
        <td>{{$mentorInfo->e_id}}</td>
      </tr>
      <tr>
        <th>email</th>
        <td></td>
        <td>{{$mentorInfo->email}}</td>
      </tr>
      <tr>
        <th>Name</th>
        <td></td>
        <td>{{$mentorInfo->first_name}} {{$mentorInfo->mid_name}} {{$mentorInfo->last_name}}</td>
      </tr>
      <tr>
        <th>Department id</th>
        <td></td>
        <td>{{$mentorInfo->department_id}}</td>
      </tr>
      <tr>
        <th>DOB</th>
        <td></td>
        <td>{{$mentorInfo->dob}}</td>
      </tr>
      <tr>
        <th>Mobile</th>
        <td></td>
        <td>{{$mentorInfo->mobile}}</td>
      </tr>
      <tr>
        <th>Address</th>
        <td></td>
        <td>{{$mentorInfo->address}}</td>
      </tr>
      <tr>
        <th>Pin code</th>
        <td></td>
        <td>{{$mentorInfo->pincode}}</td>
      </tr>
      <tr>
        <th>Concol</th>
        <td></td>
        <td>{{$mentorInfo->concol}}</td>
      </tr>
      <tr>
        <th>Aadhar id</th>
        <td></td>
        <td>{{$mentorInfo->aadhaar_id}}</td>
      </tr>
      <tr>
        <th>Pancard</th>
        <td></td>
        <td>{{$mentorInfo->pancard}}</td>
      </tr>
      <tr>
        <th>Permanent</th>
        <td></td>
        @if ($mentorInfo->is_permanent == 1)
          <td>YES</td>
        @else
          <td>NO</td>
        @endif
      </tr>
      <tr>
        <th>Research Paper</th>
        <td></td>
        <td>{{$mentorInfo->no_of_research_papers}}</td>
      </tr>
      <tr>
        <th>Last active</th>
        <td></td>
        <td>{{$mentorInfo->last_active}}</td>
      </tr>
    </table>
  </div>


--}}
