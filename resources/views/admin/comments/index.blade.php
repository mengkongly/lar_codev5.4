@extends('layouts.admin')

@section('content')

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <h2>Comments</h2>

    <div class="row">
        @if (session('success_comment')!==null)
            <div class="alert alert-success">{{session('success_comment')}}</div>
        @endif
        @if (count($comments)>0)
            <table class="table table-bordered">
                <tr>
                    <th>ID</th>
                    <th>Post Name</th>
                    <th>Author</th>
                    <th>Comment</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
                @foreach ($comments as $comment)
                    <tr>
                        <td>{{$comment->id}}</td>
                        <td><a href="{{route('post.detail',$comment->post->slug)}}">{{$comment->post->title}}</a></td>
                        <td>{{$comment->user->name}}</td>
                        <td>{{$comment->body}}</td>
                        <td>{{$comment->created_at->diffForHumans()}}</td>
                        <td class="col-md-3">
                            @if ($comment->is_active==1)
                                <a href="{{route('comments.update',['id'=>$comment->id])}}" class="btn btn-success unapprove">Unapproved</a>
                            @else
                                <a href="{{route('comments.update',['id'=>$comment->id])}}" class="btn btn-info approve">Approved</a>
                            @endif
                                
                            <a href="{{route('comments.destroy',['id'=>$comment->id])}}" class="btn btn-danger delete">Delete</a>
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    @else
        <h2>No Comment</h2>
    @endif
    
    
@endsection
@section('footer')
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $(document).on('click','.unapprove',function(e){        
            e.preventDefault(); // does not go through with the link.
            var $this = $(this);
            $.ajax({
                type    : 'PATCH', 
                url     : $this.attr('href'),
                data: {
                    "_method": 'PATCH',
                    "is_active":'0'
                },
                encode  : true,
                success:function(data) {
                //    alert(data);
                    if(data.trim()=='success'){
                        
                        location.reload();
                    }else{
                        alert('Update failed');
                    }
                }
            });
        });
        $(document).on('click','.approve',function(e){        
            e.preventDefault(); // does not go through with the link.
            var $this = $(this);
            $.ajax({
                type    : 'PATCH', 
                url     : $this.attr('href'),
                data: {
                    "_method": 'PATCH',
                    "is_active": '1'
                },
                encode  : true,
                success:function(data) {
                //    alert(data);
                    if(data.trim()=='success'){
                        location.reload();
                    }else{
                        alert('Update failed');
                    }
                }
            });
        });
        $(document).on('click','.delete',function(e){        
            e.preventDefault(); // does not go through with the link.

            if(confirm('Are you sure you want to delete this comment?')){
                var $this = $(this);                
                $.ajax({
                    type    : 'DELETE', 
                    url     : $this.attr('href'),
                    data: {
                        "_method": 'DELETE'
                    },
                    encode  : true,
                    success:function(data) {
                    //    alert(data);
                       if(data.trim()=='success'){
                           location.reload();
                       }else{
                           alert('Delete failed');
                       }
                    }
                });
            }
        });
    </script>
@endsection