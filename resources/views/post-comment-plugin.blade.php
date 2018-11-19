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
    <p>{!! $post->body !!}</p>
    
    
    <hr>

    <!-- Blog Comments -->
    {{-- Using disqus comment plugin --}}
    <div id="disqus_thread"></div>
    <script>

    /**
    *  RECOMMENDED CONFIGURATION VARIABLES: EDIT AND UNCOMMENT THE SECTION BELOW TO INSERT DYNAMIC VALUES FROM YOUR PLATFORM OR CMS.
    *  LEARN WHY DEFINING THESE VARIABLES IS IMPORTANT: https://disqus.com/admin/universalcode/#configuration-variables*/
    /*
    var disqus_config = function () {
    this.page.url = PAGE_URL;  // Replace PAGE_URL with your page's canonical URL variable
    this.page.identifier = PAGE_IDENTIFIER; // Replace PAGE_IDENTIFIER with your page's unique identifier variable
    };
    */
    (function() { // DON'T EDIT BELOW THIS LINE
    var d = document, s = d.createElement('script');
    s.src = 'https://codehack54.disqus.com/embed.js';
    s.setAttribute('data-timestamp', +new Date());
    (d.head || d.body).appendChild(s);
    })();
    </script>
    <noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
                                


</div>
<!-- Blog Sidebar Widgets Column -->
<div class="col-md-4">
    @include('layouts.post-sidebar')
</div>
@endsection

@section('scripts')
    <script id="dsq-count-scr" src="//codehack54.disqus.com/count.js" async></script>
@endsection