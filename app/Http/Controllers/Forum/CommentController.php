<?php

namespace App\Http\Controllers\Forum;

use App\Comment;
use App\Http\Controllers\Controller;
use App\Thread;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function AddThreadComment(Request $request, Thread $thread)
    {
        $this->validate($request,[
            'body'=>'required'
        ]);

        $comment = new Comment();
        $comment->body = $request->body;
        $comment->user_id = auth()->user()->id;

        $thread->comments()->save($comment);

        return back()->withMessage('Comment was created');
    }

    public function addReplyComment(Request $request, Comment $comment)
    {
        $this->validate($request,[
            'body'=>'required'
        ]);

        $reply = new Comment();
        $reply->body = $request->body;
        $reply->user_id = auth()->user()->id;

        $comment->comments()->save($reply);

        return back()->withMessage('Reply created');
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function show(Comment $comment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function edit(Comment $comment)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Comment $comment)
    {
        $this->validate($request,[
            'body'=>'required'
        ]);


        $comment->body = $request->body;

        $comment->save();

        return back()->withMessage('Comment was edited');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment)
    {
        $comment->delete();
    }
}
