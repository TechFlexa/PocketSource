<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Validator;
use App\Http\Controllers\Controller;
use App\User;
use App\comment;
use App\post;
use Illuminate\Support\Facades\Auth;

class CommentsController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,$id)
    {
        $this->validate($request,[
          'title' => 'required',
          'body' => 'required',
        ]);

        //Create comment
        $post = post::where('id','=',$id)->get();
        if(count($post) == 0)
          return response()->json(['error'=>'No Such Post Exists!']);
        $comment = new comment;
        $comment->title = $request->input('title');
        $comment->body = $request->input('body');
        $comment->post_id = $id;
        $comment->user_id = auth()->user()->id;
        $comment->save();

        return response()->json(['success'=>'Comment Successfull!']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
          $comment = comment::find($id);
          if(auth()->user()->id != $comment->user_id)
          {
            return response()->json(['error'=>'Unauthorised To Edit']);
          }

          return response()->json(['Comment'=>$comment]);
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
        ]);

        $comment = comment::find($id);
        if(auth()->user()->id != $comment->user_id)
        {
          return response()->json(['error'=>'Unauthorised To Update']);
        }

        $comment->title = $request->input('title');
        $comment->body = $request->input('body');
        $comment->save();

        return response()->json(['success'=>'Comment Updated!']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $comment = comment::find($id);
        if(auth()->user()->id != $comment->user_id)
        {
          return response()->json(['error'=>'Unauthorised To Update']);
        }
        $comment->delete();
    }
}
