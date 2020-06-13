@extends('faculty.layouts.dashboard')
@section('page_heading','Dashboard')
@section('section')
{{-- <div class="row">
    <div class="col-sm-3">
        <h1>Total Faculty</h1>
        <p>
            {{count($teachFaculty)}}
        </p>
    </div>
    <div class="col-sm-9">
        <div>
            @foreach($teach as $department => $count)
                <div class="col-sm-2">
                    <h3>{{$department}}</h3>
                    {{count($count)}}
                </div>
                
            @endforeach
        </div>
        
    </div>
</div> --}}

{{-- <div class="col-md-7" style="padding:10px; padding-top: 15px; padding-bottom: 5px; border-radius:15px; background-color: #d9534f; min-width: 420px">
    <iframe src="https://calendar.google.com/calendar/embed?showTitle=0&amp;showPrint=0&amp;showTz=0&amp;height=600&amp;wkst=2&amp;bgcolor=%23d9534f&amp;src=ves.ac.in_bql0ajrt7acnqvafac8di9e1nc%40group.calendar.google.com&amp;color=%23A32929&amp;src=ves.ac.in_1h06mbn2nhd98nj3747afssvac%40group.calendar.google.com&amp;color=%235229A3&amp;ctz=Asia%2FCalcutta" style="border-radius: 0px 0px 15px 15px; min-width:400px" height="500" width="100%" frameborder="0" scrolling="no"></iframe>
</div>

@include('faculty.layouts.right_side_navbar') --}}
<div class="row">
    <div class="col-lg-12">                   
        <div id="page-heading"></div>
    </div>
    <!-- /.col-lg-12 -->
</div>
    
    <!--     <iframe src="https://calendar.google.com/calendar/embed?showTitle=0&amp;showPrint=0&amp;showTz=0&amp;height=600&amp;wkst=2&amp;bgcolor=%23FFFFFF&amp;src=ves.ac.in_bql0ajrt7acnqvafac8di9e1nc%40group.calendar.google.com&amp;color=%23A32929&amp;src=ves.ac.in_1h06mbn2nhd98nj3747afssvac%40group.calendar.google.com&amp;color=%235229A3&amp;ctz=Asia%2FCalcutta" style="border-radius: 0px 0px 15px 15px" width="100%" height="500" frameborder="0" scrolling="no"></iframe>
    </div> -->

    <iframe src="https://calendar.google.com/calendar/embed?showTitle=0&amp;showPrint=0&amp;showTz=0&amp;height=600&amp;wkst=2&amp;bgcolor=%23FFFFFF&amp;src={{session('email')}}&ctz=Asia%2FCalcutta" style="border-radius: 0px 0px 15px 15px" width="100%" height="500" frameborder="0" scrolling="no"></iframe>

@stop