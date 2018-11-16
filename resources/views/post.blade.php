@extends('layouts.blog-home')

@section('styles')
<style>
    .toggle-reply{
        cursor: pointer;
    }

</style>
@endsection

@section('content')
<!-- Blog Post Content Column -->
<div class="col-lg-8">
    <!-- Blog Post -->

    <!-- Title -->
    <h1>{{$post->title}}</h1>

    <!-- Author -->
    <p class="lead">
        by <a href="#">{{$post->user->name}}</a>
    </p>

    <hr>

    <!-- Date/Time -->
    <p><span class="glyphicon glyphicon-time"></span> Posted on {{$post->created_at->format('M d, Y') }} at {{$post->created_at->format(' h:m A')}}</p>
    {{-- <p><span class="glyphicon glyphicon-time"></span> Posted on {{$post->created_at->isoFormat('MMMM Do YYYY, h:mm:ss a') }}</p> --}}
    {{-- <p><span class="glyphicon glyphicon-time"></span> Posted on August 24, 2013 at 9:00 PM</p> --}}

    <hr>

    <!-- Preview Image -->
    <img class="img-responsive" src="{{$post->showPhoto($post)}}" alt="">

    <hr>

    <!-- Post Content -->
    {{-- <p class="lead">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ducimus, vero, obcaecati, aut, error quam sapiente nemo saepe quibusdam sit excepturi nam quia corporis eligendi eos magni recusandae laborum minus inventore?</p> --}}
    <p>{{$post->body}}</p>
    
    <hr>

    <!-- Blog Comments -->

    <!-- Comments Form -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <div class="well">
        <h4>Leave a Comment:</h4>
        <form role="form" method="POST" action="{{route('comments.store')}}">
            {{ csrf_field() }}
            <div class="form-group">
                <textarea class="form-control" rows="3" name="body"></textarea>
            </div>
            <input type="hidden" name="post_id" value="{{$post->id}}">
            <button type="submit" class="btn btn-primary btn-sm">Submit</button>
        </form>
    </div>

    <hr>

    <!-- Posted Comments -->

    <!-- Comment -->
    @if (count($comments)>0)
        @foreach ($comments as $comment)
            <div class="media">
                <a class="pull-left" href="#">
                    <img class="media-object" src="{{$comment->user->showPhoto($comment->user)}}" alt="{{$comment->user->name}}" width="50">
                </a>
                <div class="media-body">
                    <h4 class="media-heading font-weight-bold">{{$comment->user->name}}
                        <small>{{$comment->created_at->format('M d, Y') }} at {{$comment->created_at->format(' h:m A')}}</small>
                    </h4>
                    {{$comment->body}}
                    <div class="toggle-reply small text-primary">Reply</div>

                    <div class="media hidden">
                        <div class="form-group">
                            <textarea class="form-control body-reply" rows="3" name="body"></textarea>
                        </div>
                        {{-- <a href="#" class="reply-comment btn btn-primary">Submit</a> --}}
                        <a href="{{route('comment.reply',$comment->id)}}" class="btn btn-primary btn-sm reply-comment">Submit</a>
                        <a href="#" class="btn btn-info btn-sm cancel-reply">Cancel</a>
                    </div>

                    @if (count($comment->replies)>0)
                        @foreach ($comment->replies as $reply)
                            <!-- Nested Comment -->
                            <div class="media">
                                <a class="pull-left" href="#">
                                    <img class="media-object" src="{{$reply->user->showPhoto($reply->user)}}" alt="{{$reply->user->name}}" width="50">
                                </a>
                                <div class="media-body">
                                    <h4 class="media-heading">{{$reply->user->name}}
                                        <small>{{$reply->created_at->format('M d, Y') }} at {{$reply->created_at->format(' h:m A')}}</small>
                                    </h4>
                                    <p>{{$reply->body}}</p>
                                </div>
                            </div>
                            <!-- End Nested Comment -->
                        @endforeach
                    @endif
                </div>
            </div>
        @endforeach
    @endif
</div>
<!-- Blog Sidebar Widgets Column -->
<div class="col-md-4">
    @include('layouts.post-sidebar')
</div>
@endsection

@section('scripts')
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        
        $(document).on('click','.toggle-reply',function(){

            // alert('abc');
            // alert($(this).parent().find('.media').html());
            $(this).parent().find('.media').removeClass('hidden');
        });


        $(document).on('click','.cancel-reply',function(e){
            e.preventDefault();
            $(this).parent().addClass('hidden');
        });
        $(document).on('click','.reply-comment',function(e){        
            e.preventDefault(); // does not go through with the link.

            
            var $this = $(this);
            
            $.ajax({
                type    : 'POST', 
                url     : $this.attr('href'),
                data: {
                    "body": $this.parent().find('.body-reply').val()
                },
                encode  : true,
                success:function(data) {
                    //alert(data);
                    if(data.trim()=='done'){
                        location.reload();
                    }
                }
            });
        });
    </script>
@endsection