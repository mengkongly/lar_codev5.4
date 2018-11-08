@extends('layouts.admin')

@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">

    
        
    
    <h2>User List</h2>
    <div class="row">       
        @if (!empty(session('success_user')))
        <div class="alert alert-success" role="alert">
            {{session('success_user')}}
        </div>
        @endif 
        <table class="table table-bordered">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Photo</th>
                <th scope="col">Name</th>
                <th scope="col">Email</th>
                <th scope="col">Role</th>
                <th scope="col">Actived</th>
                <th scope="col">Created</th>
                <th scope="col">Action</th>
              </tr>
            </thead>
            <tbody>
            @foreach ($users as $user)
                <tr>    
                    <th scope="row">{{$loop->iteration}}</th>
                    <td>
                        <img src="{{$user->showPhoto($user)}}" alt="{{$user->name}}" height="35">
                    </td>
                    <td>{{$user->name}}</td>
                    <td>{{$user->email}}</td>                                    
                    <td>{{$user->role->name}}</td>
                    <td>{{$user->showActivedStatus($user->is_active)}}</td>
                    <td>{{$user->created_at->diffForHumans()}}</td>
                    <td>
                        <a href="{{route('users.edit',['id'=>$user->id])}}" class="btn btn-info btn-sm">Edit</a>
                        <a href="{{route('users.destroy',$user->id)}}" class="btn btn-danger btn-sm" id="btn-delete" data-method="delete" data-toggle="confirmation">Delete</a>
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

            if(confirm('Are you sure you want to delete this user?')){
                var $this = $(this);

                $.ajax({
                    type    : 'DELETE', 
                    url     : $this.attr('href'),
                    data: {
                        "_method": 'DELETE'
                    },
                    encode  : true,
                    success:function(data) {
                       alert(data);
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