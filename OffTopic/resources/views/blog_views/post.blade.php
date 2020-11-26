@extends('layouts.app')

@push('scripts')
    <script src="{{ asset('js/ajax-post-comments.js') }}"></script>
@endpush

@section('content')
    <div class="px-5">

        <div class="m-0 mt-5 mb-0">
            <h2 class="p-0 d-inline-block">{{$post->title}}</h2>

            @can('delete-post')
                <button class="btn btn-danger float-right" onclick="document.getElementById('delete-form').submit();">Delete</button>
                <form id="delete-form" action="{{ url('/blog',$post->id) }}/delete" method="POST" class="d-none">
                    @csrf
                    @method('DELETE')
                </form>
            @endcan
            @can('edit-post')
                <button class="btn btn-warning float-right mr-1"><a class="text-decoration-none text-white" href="{{ url('/blog',$post->id) }}/edit">Edit</a></button>
            @endcan
        </div>
        <small>published: {{$post->created_at}}</small>

        <div class="post-content my-4">
            <p>{!! $post->body !!}</p>
        </div>

        <hr class="mb-5">

        <div class="comments">
            @foreach($comments as $comment)
                <div class="post-comment px-5 pt-4 pb-2 mb-4 bg-light text-dark">
                    <h5 class="m-0 d-inline-block">{{ $comment->user->name }}</h5>
                    @auth
                        @if(Auth::user()->can('delete-edit-comments') || Auth::id() == $comment->user_id)
                            <div class="buttons float-right">
                                <a class="btn btn-danger" onclick="document.getElementById('delete-comment').submit();">Delete</a>
                                <button value="{{ $comment->id }}" class="btn btn-warning edit-comment">Edit</button>
                                <form id="delete-comment" action="{{ url('/blog', $post->id) }}/comment/{{ $comment->id }}/delete" method="POST" class="d-none">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </div>

                        @endif
                    @endauth
                    <br>
                    <small>published: {{ $comment->registered }}</small>
                    <div class="post-comment-content mt-3 pb-0">
                        <p>{{ $comment->body }}</p>
                    </div>
                </div>
            @endforeach

            @auth
                <div class="create-editmode-comment-btn-section clearfix mx-5 mb-3">
                    <button class="add-comment-btn btn btn-primary float-right" type="button" data-toggle="collapse" data-target="#collapse-comment-form" aria-expanded="false"  aria-controls="collapse-comment-form">Add Comment</button>
                </div>
                <div class="edit-comment-message"></div>
            @endauth

            <div class="collapse" id="collapse-comment-form">
                <div class="card card-body mb-3 py-2 px-3">
                    <form method="POST" action=" {{ url('/blog', $post->id) }}/comment/create ">
                        @csrf
                        @method('POST')

                        <label for="comment" class="m-0">Comment</label>
                        <div class="edit-mode-text text-success">You are about to create new comment!</div>
                        <textarea name="body" class="comment-body-for-submit" style="min-width: 100%" rows="5" >{{session('body')}}</textarea>
                        <div class="d-flex justify-content-center">
                            <button type="submit" class="btn btn-primary my-1 comment-form-submit-btn">Post Comment</button>
                        </div>
                    </form>
                </div>
            </div>

            {{$comments->links()}}

            <input type="hidden" value="{{url('/')}}" id="url" name="url">
        </div>
    </div>
@endsection