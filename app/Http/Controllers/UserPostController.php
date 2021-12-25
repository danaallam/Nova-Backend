<?php

namespace App\Http\Controllers;

use App\Models\UserPost;
use Illuminate\Http\Request;

class UserPostController extends Controller
{
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $posts = UserPost::where('freelancer_id', auth('user')->user()->id)->get();
        return response()->json(['status'=>200, 'posts'=>$posts]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $inputs = $request->all();
        foreach ($request->file('posts') as $item) {
            $post = new UserPost();
            $post->name = $item->store('posts');
            $post->freelancer_id = auth('user')->user()->id;
            $post->save();
        }
        return response()->json(['status'=>200, 'message'=>'Posts added']);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $posts = UserPost::with('freelancer')->where('freelancer_id', $id)->get();
        return response()->json(['status'=>200, 'posts'=>$posts]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\UserPost  $userPost
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UserPost $userPost)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\UserPost  $userPost
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserPost $userPost)
    {
        //
    }
}
