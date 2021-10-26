<?php

namespace App\Http\Controllers;

use App\Models\Media;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts=Post::orderBy('id', 'DESC')->with('all_comment')->get();
        return view('Post.index',compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|min:20|max:255',
            'description' => 'required',
            'media.*' => 'mimes:jpeg,png,gif,mp4'
        ]);

        $post=new Post();
        $post->title=$request->title;
        $post->description=$request->description;
        $post->user_id=\Auth::user()->id;
        $post->save();

        if($request->hasfile('media')) {
            foreach($request->file('media') as $file)
            {
                $fileName = time().rand(0, 1000);
                $fileName = $fileName.'.'.$file->getClientOriginalExtension();
                $file->move(public_path('/posts'),$fileName);
                $input['file_name'] = $fileName;
                $input['post_id'] = $post->id;
                Media::create($input);
            }
        }

        \Session::flash('success', 'Post Crated Successfully.');

        return redirect()->route('Post.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit($post)
    {
        $post_detail=Post::find($post);
        return view('Post.edit',compact('post_detail'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$post_id)
    {
        $request->validate([
            'title' => 'required|min:20|max:255',
            'description' => 'required',
            'media.*' => 'mimes:jpeg,png,gif,mp4'
        ]);
        $post=Post::find($post_id);
        $post->title=$request->title;
        $post->description=$request->description;
        $post->user_id=\Auth::user()->id;
        $post->save();

        if($request->hasfile('media')) {
            foreach($request->file('media') as $file)
            {
                $fileName = time().rand(0, 1000);
                $fileName = $fileName.'.'.$file->getClientOriginalExtension();
                $file->move(public_path('/posts'),$fileName);
                $input['file_name'] = $fileName;
                $input['post_id'] = $post->id;
                Media::create($input);
            }
        }

        \Session::flash('success', 'Post Updated Successfully.');

        return redirect()->route('Post.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        //
    }

    public function Like($id)
    {
        $post=Post::find($id)->increment('like');
        \Session::flash('success', 'Like Successfully.');
        return redirect()->route('Post.index');

    }

    public function UnLike($id)
    {
        $post=Post::find($id)->decrement('like');
        \Session::flash('success', 'Un Like Successfully.');
        return redirect()->route('Post.index');
    }
}
