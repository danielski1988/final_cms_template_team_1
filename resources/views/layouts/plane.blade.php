<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en" class="no-js">
<!--<![endif]-->
<head>
	<link rel="shortcut icon" type="image/png" href="{{ URL::to('images/favicon.png') }}"/>
	<meta charset="utf-8"/>
	<title>VESIT CMS</title>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta content="width=device-width, initial-scale=1" name="viewport"/>
	<meta content="" name="description"/>
	<meta content="" name="author"/>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
	
	<link rel="stylesheet" href="{{ URL::to('css/styles.css') }}" />
	<link rel="stylesheet" href="{{ URL::to('css/app2.css') }}" />

	@if(session('red'))
		<link rel="stylesheet" href="{{ URL::to('css/red.css') }}" />
	@elseif(session('dark'))
		<link rel="stylesheet" href="{{ URL::to('css/blue.css') }}" />
	@endif
	
	{{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css"> --}}
	<link rel="stylesheet" href="{{ URL::to('css/attendance.css') }}" />
	<link rel="stylesheet" href="{{ URL::to('css/classteacher.css') }}" />

	<script src="{{ URL::to('js/frontend.js')}}" type="text/javascript"></script>
	
	
</head>
<body>
	@include('layouts.validation_msgs')
	@yield('body')
	
</body>


</html>