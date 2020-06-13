@if(count($errors) > 0)
    @foreach($errors->all() as $error)
        <div class= "alert alert-danger">
            {{$error}}
        </div>
    @endforeach
@endif


@if(session('success'))
    <div class="alert alert-success alert-dismissible text-center animated fadeInDown" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        {{session('success')}}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible text-center animated fadeInDown" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        {{session('error')}}
    </div>
@endif

<script>
	$(document).ready(function(){
	    setTimeout(function(){
			if ($('.alert').length > 0) {
				$('.alert').addClass("fadeOutUp");
			}
		}, 4000);
	});
</script>