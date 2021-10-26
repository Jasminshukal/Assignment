<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;


class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    public function store($post_id,Request $request)
    {
        $request->validate([
            'comment' => 'required',
            'media' => 'mimes:jpeg,png,gif,mp4'
        ]);
        $comment=new Comment();
        $comment->comment=$request->comment;
        $comment->post_id=$post_id;
        $comment->user_id=\Auth::user()->id;
            if($request->hasfile('media')) {
                $fileName = time().rand(0, 1000);
                $fileName = $fileName.'.'.$request->media->getClientOriginalExtension();
                $request->media->move(public_path('/comment'),$fileName);
                $comment->file_name=$fileName;
            }

        if($request->has('parent_id'))
        {
            $comment->parent_id=$request->parent_id;
        }
        $comment->save();

        \Session::flash('success', 'Comment Crated Successfully.');

        return redirect()->route('Post.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function show(Comment $comment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function edit(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Comment $comment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy($comment)
    {
        //for delete files of child
        $this->delete_child_image($comment);
        $child=Comment::where('parent_id',$comment)->delete();

        //for delete files
        $this->delete_image($comment);
        $cm=Comment::where('id',$comment)->delete();

        \Session::flash('success', 'Comment Deleted Successfully.');
        return redirect()->route('Post.index');
    }

    public function delete_child_image($id)
    {
        $delete_list=Comment::where('parent_id',$id)->get();
        foreach($delete_list as $item)
        {
            $image_path = public_path('comment').'/'.$item->file_name;
            if (file_exists($image_path))
            {
                @unlink($image_path);
            }
        }
        return true;
    }

    public function delete_image($id)
    {
        $delete_list=Comment::find($id);

        $image_path = public_path('comment').'/'.$delete_list->file_name;

        if (file_exists($image_path))
        {
            @unlink($image_path);
        }
        return $image_path;

    }

}
