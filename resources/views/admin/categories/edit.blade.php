@extends('layouts.admin')

@section('content')
    <h1>Edit Category</h1>

    <div class="row">

        <form action="{{route('categories.update',$category->id)}}" class="form-horizontal" method="POST">
            
            {{ csrf_field() }}
            <input type="hidden" name="_method" value="PATCH">


            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                <label for="name" class="col-md-2 control-label">Name</label>
    
                <div class="col-md-6">
                    <input id="name" type="text" class="form-control" name="name" value="{{ !empty(old('name'))?old('name'):$category->name }}" required autofocus>
    
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
                        Update
                    </button>
                    <a href="{{route('categories.index')}}" class="btn btn-info">Cancel</a>
                </div>
            </div>
        </form>
    </div>
@endsection

@section('footer')
    
@endsection