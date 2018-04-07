<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Validator;
use App\Http\Controllers\Controller;
use App\User;
use App\post;
use Illuminate\Support\Facades\Auth;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Posts = post::all();
        return response()->json(['Posts'=>$Posts]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    //public function create()
    //{

    //}

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $this->validate($request,[
        'title' => 'required',
        'body' => 'required',
        'cover' => 'required',
      ]);

      //Create post

      $newpost = new post;
      $newpost->title = $request->input('title');
      $newpost->body = $request->input('body');
      $newpost->cover = $request->input('cover');
      $newpost->author = auth()->user()->name;
      $newpost->user_id = auth()->user()->id;
      $newpost->save();

      return response()->json(['success'=>'Post Created']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $Post = post::find($id);
        $comment = $Post->comments;
        return response()->json(['Post'=>$Post]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = post::find($id);
        if(auth()->user()->id != $post->user_id)
        {
          return response()->json(['error'=>'Unauthorised To Edit']);
        }
        else
          return response()->json(['Post'=>$post]);
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
        $this->validate($request,[
          'title' => 'required',
          'body' => 'required',
          'cover' => 'required',
        ]);

        $newpost = post::find($id);
        if(auth()->user()->id != $newpost->user_id)
        {
          return response()->json(['error'=>'Unauthorised To Edit']);
        }

        $newpost->title = $request->input('title');
        $newpost->body = $request->input('body');
        $newpost->cover = $request->input('cover');
        $newpost->save();

        return response()->json(['success'=>'Post Updated!','Post'=>$newpost]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $newpost = post::find($id);
      if(auth()->user()->id != $newpost->user_id)
      {
        return response()->json(['error'=>'Unauthorised To Edit']);
      }
      $newpost->delete();
      return response()->json(['success'=>'Deleted Successfully!']);
    }
}
