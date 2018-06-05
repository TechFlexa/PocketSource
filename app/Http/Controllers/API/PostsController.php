<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Validator;
use App\Http\Controllers\Controller;
use App\User;
use App\Post;
use Illuminate\Support\Facades\Auth;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $req_posts = Post::all();
        $posts = [];
        foreach ($req_posts as $req_post) {
            $post['id'] = $req_post['id'];
            $post['title'] = $req_post['title'];
            $post['body'] = $req_post['body'];
            $post['cover'] = $request->getSchemeAndHttpHost().'/storage/'.$req_post['cover'];
            $post['user_id'] = $req_post['user_id'];
            $post['author'] = $req_post['author'];
            $post['created_at'] = $req_post['created_at'];
            $post['updated_at'] = $req_post['updated_at'];
            array_push($posts, $post);
            $post = [];
        }

        return response()->json(["success"=> true,'data'=>$posts]);
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
        'cover' => 'image|nullable|max:1999',
      ]);

      //Handle File Upload
      if($request->hasFile('cover_image')){
          $fileNameext = $request->file('cover_image')->getClientOriginalName();
          $fileName = pathinfo($fileNameext, PATHINFO_FILENAME);
          $ext = $request->file('cover_image')->getClientOriginalExtension();
          $fileNameStore = $fileName.'_'.time().'.'.$ext;
          $path = $request->file('cover_image')->storeAs('public/cover_images', $fileNameStore);
      }
      else{
          $fileNameStore = 'noimage.jpg';
      }

      //Create post

      $newpost = new post;
      $newpost->title = $request->input('title');
      $newpost->body = $request->input('body');
      $newpost->cover = $fileNameStore;
      $newpost->author = auth()->user()->name;
      $newpost->user_id = auth()->user()->id;
      $newpost->save();

      return response()->json(['success'=>true,'data'=>$newpost]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $Post = Post::find($id);
        $comment = $Post->comments;
        return response()->json(["success" => true,'data'=>$Post]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::find($id);
        if(auth()->user()->id != $post->user_id)
        {
          return response()->json(['error'=>'Unauthorised To Edit']);
        }
        else
          return response()->json(['data'=>$post]);
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

        $newpost = Post::find($id);
        if(auth()->user()->id != $newpost->user_id)
        {
          return response()->json(['error'=>'Unauthorised To Update']);
        }

        $newpost->title = $request->input('title');
        $newpost->body = $request->input('body');
        $newpost->cover = $request->input('cover');
        $newpost->save();

        return response()->json(['success'=>'Post Updated!','data'=>$newpost]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $newpost = Post::find($id);
      if(auth()->user()->id != $newpost->user_id)
      {
        return response()->json(['error'=>'Unauthorised To Delete']);
      }
      $newpost->delete();
      return response()->json(['success'=>'Deleted Successfully!']);
    }
}
