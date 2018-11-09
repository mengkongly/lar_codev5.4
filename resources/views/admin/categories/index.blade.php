@extends('layouts.admin')

@section('content')
    <h1>Categories List</h1>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <div class="row">       
        @if (!empty(session('success_cate')))
        <div class="alert alert-success" role="alert">
            {{session('success_cate')}}
        </div>
        @endif 
        @if (!empty(session('error_cate')))
            <div class="alert alert-danger" role="alert">
                {{session('error_cate')}}
            </div>
        @endif
        <table class="table table-bordered">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Category</th>                
                <th scope="col">Created</th>
                <th scope="col">Action</th>
              </tr>
            </thead>
            <tbody>
            @foreach ($categories as $category)
                <tr>    
                    <th scope="row">{{$loop->iteration}}</th>
                    <td>{{$category->name}}</td>
                    <td>{{$category->created_at->diffForHumans()}}</td>
                    <td class="col-md-2">
                        <a href="{{route('categories.edit',['id'=>$category->id])}}" class="btn btn-info btn-sm">Edit</a>
                        <a href="{{route('categories.destroy',$category->id)}}" class="btn btn-danger btn-sm" id="btn-delete" data-method="delete" data-toggle="confirmation">Delete</a>
                    </td>
                </tr>
                
            @endforeach
                            
            </tbody>
        </table>
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

            if(confirm('Are you sure you want to delete this category?')){
                var $this = $(this);

                $.ajax({
                    type    : 'DELETE', 
                    url     : $this.attr('href'),
                    data: {
                        "_method": 'DELETE'
                    },
                    encode  : true,
                    success:function(data) {
                        //alert(data);
                       if(data.trim()=='done'){
                           location.reload();
                       }
                    }
                });
            }
        });
    </script>
@endsection