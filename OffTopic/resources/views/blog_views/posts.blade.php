@extends('layouts.app')

@section('content')
    <div class="px-5">
        <div class="row m-0 my-5">

            <h2 class="col-10 p-0">Blog Posts</h2>
            @can('create-post')
               <a class="col-2 btn btn-primary text-decoration-none text-white d-flex align-items-center justify-content-center" href="{{ url('/blog/create') }}"><span>Create</span></a>
            @endcan
        </div>
        <div class="posts-content">

            @if(count($posts) > 0)
                @foreach($posts as $post)

                    <div class="post mb-3">
                        <div class="card">
                            <div class="card-header">
                                <h4><a href="{{ url('blog', $post->id) }}">{{$post->title}}</a></h4>
                                <small class="mb-0">Published on {{$post->created_at}}</small>
                                <strong class="float-right">Comments: {{ $post->comments_count }}</strong>
                            </div>
                        </div>
                    </div>

                @endforeach

                {{$posts->links()}}

            @else
                <p class="text-center bg-dark text-white">There are no posts yet.</p>
            @endif

        </div>
    </div>
@endsection