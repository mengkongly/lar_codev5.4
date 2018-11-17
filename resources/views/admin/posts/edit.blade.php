@extends('layouts.admin')

@section('content')
<h2>Create Post</h2>
<h1 class="page-header"></h1>
<div class="row">
    @include('includes.tinyeditor')
    <form class="form-horizontal" method="POST" action="{{ route('posts.update',$post->id) }}" enctype="multipart/form-data">
        {{ csrf_field() }}

        <input type="hidden" name="_method" value="PATCH">
        <input type="hidden" name="id" value="{{$post->id}}">
        <div class="form-group col-md-3">
            {{-- <img src="{{asset('images/default-post.jpg')}}" alt="" width="200"> --}}
            <img src="{{$post->showPhoto($post)}}" alt="{{$post->title}}" height="200">
        </div>
        <div class="col-md-9">
            <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                <label for="title" class="col-md-2 control-label">Title</label>
    
                <div class="col-md-6">
                    <input id="title" type="text" class="form-control" name="title" value="{{old('title')!=null?old('title'):$post->title}}" required autofocus>
    
                    @if ($errors->has('title'))
                        <span class="help-block">
                            <strong>{{ $errors->first('title') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
    
            <div class="form-group{{ $errors->has('category_id') ? ' has-error' : '' }}">
                <label for="category" class="col-md-2 control-label">Category</label>
                <div class="col-md-6">
                    <select class="form-control" id="category" name="category_id">
                        @foreach ($categories as $category)
                            @if (!empty(old('category_id')) || $post->category_id==$category->id)
                                <option value="{{$category->id}}" selected>{{$category->name}}</option>
                            @else
                                <option value="{{$category->id}}">{{$category->name}}</option>
                            @endif
                            
                        @endforeach
                    </select>
                    @if ($errors->has('category_id'))
                        <span class="help-block">
                            <strong>{{ $errors->first('category_id') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
    
            <div class="form-group{{ $errors->has('body') ? ' has-error' : '' }}">
                <label for="body" class="col-md-2 control-label">Password</label>
    
                <div class="col-md-10">
                <textarea name="body" id="body" class="form-control" cols="30" rows="10">{{old('body')!=null?old('body'):$post->body}}</textarea>
    
                    @if ($errors->has('body'))
                        <span class="help-block">
                            <strong>{{ $errors->first('body') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
    
            <div class="form-group{{ $errors->has('file') ? ' has-error' : '' }}">
                <label for="file_upload" class="col-md-2 control-label">Photo</label>
                <div class="col-md-3">
                    <input type="file" class="form-control-file" id="file_upload" name="file">                                
                    @if ($errors->has('file'))
                        <span class="help-block">
                            <strong>{{ $errors->first('file') }}</strong>
                        </span>
                    @endif
                </div>            
            </div>
    
            <div class="form-group">
                <div class="col-md-6 col-md-offset-2">
                    <button type="submit" class="btn btn-primary">
                        Update
                    </button>
                    <a href="{{route('posts.index')}}" class="btn btn-info">Cancel</a>
                </div>
            </div>

        </div>
        
    </form>
</div>

@endsection
