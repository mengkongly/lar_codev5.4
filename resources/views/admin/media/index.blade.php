@extends('layouts.admin')

@section('content')

<h1>Media</h1>
<div class="row">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @if (!empty(session('success_photo')))
        <div class="alert alert-success" role="alert">
            {{session('success_photo')}}
        </div>
    @endif 
    @if (!empty(session('error_photo')))
        <div class="alert alert-danger" role="alert">
            {{session('error_photo')}}
        </div>
    @endif
    @if ($photos)
        <form action="{{route('medias.deletes')}}" method="POST" class="form-inline">
            {{ csrf_field() }}
            <div class="form-group">
                <select class="form-control">
                    <option value="delete">Delete</option>
                </select>                
            </div>
            <div class="form-group">
                <input type="submit" value="Submit" name="submit" class="form-control btn-danger">
            </div>
            <table class="table">
                <thead>
                    <tr>
                        <th><input type="checkbox" id="checkAll"></th>
                        <th>ID</th>
                        <th>Photo</th>
                        <th>Name</th>
                        <th>Created</th>
                        <th>Action</th>
                    </tr>
                </thead>
                @foreach ($photos as $photo)
                    <tr>
                        <td><input type="checkbox" name="checkboxMedias[]" class="checkBoxs" value="{{$photo->id}}"></td>
                        <td>{{$photo->id}}</td>
                        <td>
                            <img src="{{asset($photo->path)}}" height="50">
                        </td>
                        <td>{{$photo->path}}</td>
                        <td>{{$photo->created_at->diffForHumans()}}</td>
                        <td>
                            <a href="{{route('medias.edit',['id'=>$photo->id])}}" class="btn btn-info btn-sm">Edit</a>
                            <a href="{{route('medias.destroy',$photo->id)}}" class="btn btn-danger btn-sm" id="btn-delete" data-method="delete" data-toggle="confirmation">Delete</a>
                        </td>

                    </tr>
                @endforeach
            </table>
        </form>
    @endif        

</div>
    
@endsection

@section('scripts')
<script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $(document).on('click','#btn-delete',function(e){        
            e.preventDefault(); // does not go through with the link.

            if(confirm('Are you sure you want to delete this photo?')){
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

        $(document).on('click','#checkAll',function(){
            if($(this).is(':checked')){
                $('.checkBoxs').prop('checked',true);
            }else{
                $('.checkBoxs').prop('checked',false);
            }
        });
    </script>
    
@endsection