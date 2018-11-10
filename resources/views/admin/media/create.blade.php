@extends('layouts.admin')

@section('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.css">
@endsection


@section('content')
<h1>Create Media</h1>

<form action="{{route('medias.store')}}" class="dropzone" method="POST" enctype="multipart/form-data">
    {{ csrf_field() }}
    <div class="fallback">
      <input name="file" type="file" multiple />
    </div>
</form>
    
@endsection


@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.js"></script>
@endsection