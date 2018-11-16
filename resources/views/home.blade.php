@extends('layouts.blog-home')
{{-- @extends('layouts.app') --}}


@section('content')
    <!-- Blog Entries Column -->
    <div class="col-md-8">

        <h1 class="page-header">
            Page Heading
            <small>Secondary Text</small>
        </h1>

        @if (count($posts)>0)
            
            @foreach ($posts as $post)
                <!-- First Blog Post -->
                <h2>
                    <a href="#">{{$post->title}}</a>
                </h2>
                <p class="lead">
                    by <a href="index.php">{{$post->user->name}}</a>
                </p>
                <p><span class="glyphicon glyphicon-time"></span> Posted on {{$post->created_at->format('M d, Y') }} at {{$post->created_at->format(' h:m A')}}</p>
                <hr>
                <img class="img-responsive" src="{{$post->showPhoto($post)}}" height="300" alt="">
                <hr>
                <p>{{$post->body}}</p>
                <a class="btn btn-primary" href="{{route('post.detail',$post->slug)}}">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>

                <hr>

            @endforeach
        @endif
        


        <!-- Pager -->
        {{-- <ul class="pager">
            <li class="previous">
                <a href="#">&larr; Older</a>
            </li>
            <li class="next">
                <a href="#">Newer &rarr;</a>
            </li>
        </ul> --}}
        {{$posts->links()}}

    </div>

    <!-- Blog Sidebar Widgets Column -->
    <div class="col-md-4">
        @include('layouts.post-sidebar')
    </div>
@endsection

