@extends('layouts.admin')

@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <h1>Posts List</h1>
    <div class="row">       
        @if (session('success_post')!==null)
            <div class="alert alert-success">{{session('success_post')}}</div>
        @endif
        <table class="table table-bordered">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Photo</th>
                <th scope="col">Title</th>
                <th scope="col">Category</th>
                <th scope="col">Description</th>
                <th scope="col">Created</th>
                <th scope="col">Action</th>
              </tr>
            </thead>
            <tbody>

            @foreach ($posts as $key => $post)
                <tr>    
                    <th scope="row">{{$posts->firstItem()+$key}}</th>
                    <td>
                        <img src="{{$post->showPhoto($post)}}" alt="{{$post->title}}" height="35">
                    </td>
                    <td><a href="{{route('post.detail',$post->slug)}}">{{str_limit($post->title,30)}}</a></td>
                    <td>{{$post->category->name}}</td>
                    <td>{{str_limit($post->body,30)}}</td>
                    <td>{{$post->created_at->diffForHumans()}}</td>
                    <td>
                        <a href="{{route('posts.edit',['id'=>$post->id])}}" class="btn btn-info btn-sm">Edit</a>
                        <a href="{{route('posts.destroy',$post->id)}}" class="btn btn-danger btn-sm" id="btn-delete" data-method="delete" data-toggle="confirmation">Delete</a>
                    </td>
                </tr>
                
            @endforeach
                            
            </tbody>
          </table>
          <div class="row">
            <div class="col-md-6 col-md-offset-5">{{$posts->links()}}</div>
          </div>
    </div>
@endsection

@section('footer')
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $(document).on('click','#btn-delete',function(e){        
            e.preventDefault(); // does not go through with the link.

            if(confirm('Are you sure you want to delete this post?')){
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