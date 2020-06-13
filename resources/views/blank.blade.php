@extends('layouts.plane')
<link rel="stylesheet" href="{{ URL::to('css/homepage.css') }}" />
@section('body')
<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
    <div class="navbar-header">
        <a class="navbar-brand" href="{{ url ('') }}">
            <img src="{{ URL::to('images/cms-brand.png') }}" alt="brand logo">
        </a>
    </div>
    <!-- /.navbar-header -->

    <ul class="nav navbar-top-links navbar-right">

        
        <!-- /.dropdown -->
        <li class="dropdown">
             <a href="{{ url ('login') }}">Login <i class="fa fa-user fa-fw"></i></a>
        </li>
        
        <!-- /.dropdown -->
    </ul>
    <!-- /.navbar-top-links -->
</nav>
<br>
<br>
<br>
<br>
{{-- <div class="fluid-container" id="banner">
    <div class="container">
        <div class="row">
            
        </div>
    </div>
</div> --}}

<header class="logo-header" id="banner">

</header>

<nav class="navbar navbar-default navbar-static-bottom">

    <!-- /.navbar-header -->

    <ul class="nav navbar-top-links navbar-right">

        
        <!-- /.dropdown -->
        <li class="dropdown">
             <a href="">Help</a>
        </li>
        <li class="dropdown">
             <a href="">Privacy</a>
        </li>
        <li class="dropdown">
             <a href="">Developers</a>
        </li>

        
        <!-- /.dropdown -->
    </ul>
    <!-- /.navbar-top-links -->
</nav>
{{-- <footer>
    <div  class="container">
        <h1>Footer Content Here</h1>
    </div>
    
</footer> --}}
@stop