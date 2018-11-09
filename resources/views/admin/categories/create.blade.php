@extends('layouts.admin')

@section('content')
<h2>Create Category</h2>
<h1 class="page-header"></h1>
<div class="row">
    <form class="form-horizontal" method="POST" action="{{ route('categories.store') }}">
        {{ csrf_field() }}

        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
            <label for="name" class="col-md-2 control-label">Name</label>

            <div class="col-md-6">
                <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>

                @if ($errors->has('name'))
                    <span class="help-block">
                        <strong>{{ $errors->first('name') }}</strong>
                    </span>
                @endif
            </div>
        </div>        

        <div class="form-group">
            <div class="col-md-6 col-md-offset-2">
                <button type="submit" class="btn btn-primary">
                    Create
                </button>
                <a href="{{route('categories.index')}}" class="btn btn-info">Cancel</a>
            </div>
        </div>
    </form>
</div>
@endsection

@section('footer')
    
@endsection