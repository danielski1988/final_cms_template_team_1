{{-- Errors --}}
@if (count($errors)>0)
  @foreach ($errors->all() as $error)
    <div class="alert alert-danger">
      {{$error}}
    </div>
  @endforeach
@endif

{{-- Success --}}
@if (session('success'))
  <div class="alert alert-success">
    {{session('success')}}
  </div>
@endif

{{-- Session Error --}}
@if (count($errors)>0)
  <div class="alert alert-danger">
    {{session('error')}}
  </div>
@endif
