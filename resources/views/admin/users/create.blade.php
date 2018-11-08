@extends('layouts.admin')

@section('content')
<h2>Create User From</h2>
<h1 class="page-header"></h1>
<div class="row">
    <form class="form-horizontal" method="POST" action="{{ route('users.store') }}" enctype="multipart/form-data">
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

        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
            <label for="email" class="col-md-2 control-label">E-Mail Address</label>

            <div class="col-md-6">
                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

                @if ($errors->has('email'))
                    <span class="help-block">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <div class="form-group{{ $errors->has('role_id') ? ' has-error' : '' }}">
            <label for="role" class="col-md-2 control-label">User Role</label>
            <div class="col-md-6">
                <select class="form-control" id="role" name="role_id">
                    @foreach ($roles as $role)
                        <option value="{{$role->id}}">{{$role->name}}</option>
                    @endforeach
                </select>
                @if ($errors->has('role_id'))
                    <span class="help-block">
                        <strong>{{ $errors->first('role_id') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
            <label for="password" class="col-md-2 control-label">Password</label>

            <div class="col-md-6">
                <input id="password" type="password" class="form-control" name="password" required>

                @if ($errors->has('password'))
                    <span class="help-block">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <div class="form-group{{ $errors->has('file') ? ' has-error' : '' }}">
            <label for="file_upload" class="col-md-2 control-label">Photo</label>
            <div class="col-md-6">
                <input type="file" class="form-control-file" id="file_upload" name="file">
                @if ($errors->has('file'))
                    <span class="help-block">
                        <strong>{{ $errors->first('file') }}</strong>
                    </span>
                @endif
            </div>            
        </div>

        <div class="form-group">
            <div class="form-check col-md-6 col-md-offset-2">
                <input class="form-check-input" type="checkbox" id="gridCheck" name="is_active">
                <label class="form-check-label" for="gridCheck">
                Activated
                </label>
            </div>
        </div>

        <div class="form-group">
            <div class="col-md-6 col-md-offset-2">
                <button type="submit" class="btn btn-primary">
                    Create
                </button>
                <a href="{{route('users.index')}}" class="btn btn-info">Cancel</a>
            </div>
        </div>
    </form>
</div>

@endsection
