@extends('layouts.app')

@section('content')
    <div class="px-5">

        <h2 class="my-5">Edit Post</h2>
        <div class="form-post-content">
            <form method="POST" action="{{ url('/blog', @$post->id) }}/update">
                @csrf
                @method('PUT')

                <input type="hidden" name="user_id" value="{{ Auth::id() }}">

                <label for="title">Title</label><br />
                <input id="title" type="text" name="title" value="{{ @$post->title }}{{ @$formData['title'] }}"><br/><br/>


                <label for="body">Text</label><br />
                <textarea name="body" id="body" style="min-width: 100%" rows="10">{{ @$post->body }}{{ @$formData['body'] }}</textarea><br>


                <div class="row float-right mx-0 my-3">
                    <button class="btn btn-dark"><a href="{{ url('/blog') }}">Cancel</a></button>
                    <button type="submit" class="btn btn-primary ml-2">Edit</button>
                </div>
            </form>

        </div>
    </div>
@endsection