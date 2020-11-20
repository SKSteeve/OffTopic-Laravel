<?php

namespace App\Http\Controllers;

use App\Post;
use Gate;
use Illuminate\Http\Request;
use App\Services\PostsService;

class PostsController extends Controller
{
    /**
     * PostsController constructor.
     * Use auth middleware.
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::orderBy('created_at', 'desc')->withCount('comments')->paginate(5);

        return view('blog_views.posts')->with('posts', $posts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Gate::denies('create-post')) {
            return redirect('/blog')->with('error', 'Access denied!');
        }

        return view('blog_views.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validateResponse = PostsService::validate($request->all());

        if($validateResponse['status'] == -1) {
            $errors = $validateResponse['errors'];
            return view('blog_views.create')->with(['errors' => $errors, 'formData' => $request->all()]);
        }

        $post = new Post;
        $post::create($request->all());

        return redirect('/blog')->with('success', 'The post was created!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::find($id);
        $comments = Post::find($id)->comments()->orderBy('created_at', 'desc')->paginate(5);

        return view('blog_views.post')->with(['post' => $post, 'comments' => $comments]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(Gate::denies('edit-post')) {
            return redirect("/blog/$id")->with('error', 'Access denied!');
        }

        $post = Post::find($id);

        return view('blog_views.edit')->with('post', $post);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validateResponse = PostsService::validate($request->all());

        if($validateResponse['status'] == -1) {
            $errors = $validateResponse['errors'];
            return redirect("/blog/$id/edit")->with('errors', $errors);
        }

        Post::find($id)->update($request->all());
        return redirect("/blog/$id")->with('success', 'The Post was Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(Gate::denies('delete-post')) {
            return redirect("/blog/$id")->with('error', 'Access denied!');
        }

        Post::find($id)->comments()->delete();
        Post::find($id)->delete();

        return redirect('/blog')->with('success', 'The Post was Deleted');
    }
}
