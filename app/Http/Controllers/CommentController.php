<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Http\Requests\CommentRequest;
use App\Post;
use Illuminate\Http\Request;

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
    public function store(Request $request)
    {
        $comment = new Comment();
        $comment->content = $request->content;
        $comment->post_id = $request->id;
        auth()->user()->comments()->save($comment);
        if ($request->comment_parent_id) {
            $comment->comment_parent_id = $request->comment_parent_id;
        }
        $comment->save();


        return response(['message' => 'comment is added successfully'], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }
    public function postComments($id)
    {
        $comments = Comment::with('user')->where([
            ['post_id', $id,],
            ['comment_parent_id', null]
        ])->orderby('created_at','desc')->get();
        return response()->json(['comments' => $comments], 200);
    }

    // comment replies

    public function commentReplies($id)
    {
        $comment=Comment::find($id);
        $replies=$comment->replies()->with('user')->orderby('created_at', 'desc')->get();
        return response()->json(['replies' => $replies], 200);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CommentRequest $request, $id)
    {
        if ($request->user_id == auth()->user()->id) {
            $comment = Comment::find($id);
            $comment->content = $request->content;
            $comment->save();
        }
        return response(['messege' => 'comment has been updated successfully'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Comment::destroy($id);
        return response(['messege' => 'comment has been deleted successfully'], 200);
    }
}
