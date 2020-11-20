@extends('layouts.app')

@push('scripts')
{{--    <script src="{{ asset('js/ajax-posts.js') }}"></script>--}}
@endpush

@section('content')
    <div class="px-5">
        <div class="row m-0 my-5">

            <h2 class="col-10 p-0">Blog Posts</h2>
            @can('create-post')
                <button class="col-2 btn btn-primary"><a class="text-decoration-none text-white" href="{{ url('/blog/create') }}">Create</a></button>
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
                <p>No posts found</p>
            @endif

        </div>
    </div>
@endsection