<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;
use App\PostComment;
use Illuminate\Support\Facades\Auth;
use Gate;

class PostCommentController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {
        if (Auth::check()) {
            $comment = new PostComment();
            $comment->body = $request->input('body');
            $comment->user_id = Auth::id();

            $post = Post::find($id);
            $post->comments()->save($comment);

            return redirect("/blog/$id")->with('success', 'Successfully added comment !');
        }
        return redirect("/blog/$id")->with('error', 'Access denied! To create new comment you need to be logged in.');
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $commentId = $request->input('id');
        $data = $request->all();
        $comment = PostComment::find($commentId);

        if(Gate::allows('delete-edit-comments') || Auth::id() == $comment->user_id) {
            $comment->update($data);
            return response()->json(['commentData' => $data, 'success' => 'Comment Updated!']);
        }

        return redirect("/blog")->with('error', 'Access denied ! You are not allowed to update this comment!');
    }


    public function edit($commentId)
    {
        $commentBody = PostComment::find($commentId)->body;

        return response()->json(['commentBody' => $commentBody]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($postId, $commentId)
    {
        $comment = PostComment::find($commentId);

        if(Gate::allows('delete-edit-comments') || Auth::id() == $comment->user_id) {
            $comment->delete();
            return redirect("/blog/$postId")->with('success', 'Comment deleted !');
        }

        return redirect("/blog/$postId")->with('error', 'Access denied! Comment
             cant be deleted!');

    }
}
