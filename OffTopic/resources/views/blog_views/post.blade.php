@extends('layouts.app')

@push('scripts')
{{--    <script src="{{ asset('js/ajax-post-comments.js') }}"></script>--}}
@endpush

@section('content')
    <div class="px-5">

        <div class="row m-0 mt-5 mb-0">
            <h2 class="col-9 p-0">{{$post->title}}</h2>

            @can('delete-post')
                <button class="col-1 btn btn-danger mr-2 ml-5" onclick="document.getElementById('delete-form').submit();">Delete</button>
                <form id="delete-form" action="{{ url('/blog',$post->id) }}/delete" method="POST" class="d-none">
                    @csrf
                    @method('DELETE')
                    {{--  <input type="hidden" value="{{url('/')}}" id="url" name="url">--}}
                </form>
            @endcan
            @can('edit-post')
                <button class="col-1 btn btn-warning"><a class="text-decoration-none text-white" href="{{ url('/blog',$post->id) }}/edit">Edit</a></button>
            @endcan
        </div>
        <small>published: {{$post->created_at}}</small>

        <div class="post-content my-4">
            <p>{{$post->body}}</p>
        </div>

        <hr class="mb-5">

        <div class="comments">
            @foreach($comments as $comment)
                <div class="post-comment px-5">
                    <h5 class="m-0 d-inline-block">{{ $comment->user->name }}</h5>
                    @auth
                        @if(Auth::user()->can('delete-edit-comments') || Auth::id() == $comment->user_id)
                            <div class="buttons float-right">
                                <a class="btn btn-danger" onclick="document.getElementById('delete-comment').submit();">Delete</a>
                                <button value="{{ $comment->id }}" class="btn btn-warning edit-comment">Edit</button>
                                <form id="delete-comment" action="{{ url('/blog', $post->id) }}/comment/{{ $comment->id }}/delete" method="POST" class="d-none">
                                    @csrf
                                    @method('DELETE')
                                    {{--  <input type="hidden" value="{{url('/')}}" id="url" name="url">--}}
                                </form>
                            </div>

                        @endif
                    @endauth
                    <br>
                    <small>published: {{ $comment->created_at }}</small>
                    <div class="post-comment-content my-4">
                        <p>{{ $comment->body }}</p>
                    </div>
                    <hr>
                </div>
            @endforeach

            @auth
                <button id="add-comment" class="btn btn-primary mx-5 float-right" type="button" data-toggle="collapse" data-target="#collapse-comment-form" aria-expanded="false"  aria-controls="collapse-comment-form">Add Comment</button><br/><br/>
            @endauth

            <div class="collapse" id="collapse-comment-form">
                <div class="card card-body mb-3 py-2 px-3">
                    <form method="POST" action=" {{ url('/blog', $post->id) }}/comment/create ">
                        @csrf
                        @method('POST')

                        <label for="comment">Comment</label>
                        <textarea name="body" class="comment" style="min-width: 100%" rows="5" ></textarea>
                        <div class="d-flex justify-content-center">
                            <button type="submit" class="btn btn-primary my-1 comment-form-submit-btn">Submit</button>
                        </div>
                    </form>
                </div>
            </div>

            {{$comments->links()}}

            <input type="hidden" value="{{url('/')}}" id="url" name="url">
        </div>
    </div>
@endsection