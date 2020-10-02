<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Post;
use App\PostImage;
use App\User;
use Carbon\CarbonInterval;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session as FacadesSession;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $userIds = $user->friends->pluck('id')->toArray();
        array_push($userIds, $user->id);
        $posts = Post::with('user', 'images')->whereIn('user_id', $userIds)->orderby('created_at', 'desc')->paginate(5);
        return response()->json([
            'posts' => $posts
        ]);
    }
    public function friendPosts(Request $request)
    {

        $user = User::find($request->userId);
        $updatedPosts = $user->posts()->with('user')->orderby('created_at', 'desc')->paginate(5);
        FacadesSession::flash('selectedUser', $user->id);
        return redirect()->route('indexpage')->with(['posts' => $updatedPosts]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostRequest $request)
    {
        $post = new Post();
        $post->post_title = $request->title;
        $post->post_content = $request->content;
        auth()->user()->posts()->save($post);
        $post->save();
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $image = new PostImage();
                $path = $file->store('postimages');
                $image->image_path = public_path().$path;
                $post->images()->save($image);
                $image->save();
            }
        }

        return response(['message' => 'post is added successfully', 'post' => $post->load('user', 'images')], 200);
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
        $comments = $post->comments()->with('user')->orderby('created_at', 'desc')->get();
        return view('onePost')->with(['comments' => $comments, 'post' => $post]);
    }

    /**     
     * Show the form for editing the specified resource.
     *                                                                                                                                               
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PostRequest $request, $id)
    {

        if ($request->user_id == auth()->user()->id) {
            $post = Post::find($id);
            $post->post_title = $request->title;
            $post->post_content = $request->content;
            $post->save();
        }
        return response(['messege' => 'post has been updated successfully'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        // dd($request->all());
        // if ($request->user_id == auth()->user()->id) {
        Post::destroy($id);
        // }
        return response(['messege' => 'post has been deleted successfully']);
    }
}
