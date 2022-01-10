<?php

namespace App\Http\Controllers;

use App\Http\Resources\CommentsResource;
use App\Models\Comment;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        return CommentsResource::collection(Comment::paginate(5));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return CommentsResource
     */
    public function store(Request $request)
    {
        $comment = Comment::create([
            'tweet_id' => $request->tweet_id,
            'user_id' => $request->user_id,
            'body' => $request->body,
        ]);
        return new CommentsResource($comment);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Comment $comment
     * @return CommentsResource
     */
    public function show(Comment $comment)
    {
        return new CommentsResource($comment);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Comment $comment
     * @return CommentsResource
     */
    public function update(Request $request, Comment $comment)
    {
        $comment->update([
            'tweet_id' => $request->tweet_id,
            'user_id' => $request->user_id,
            'body' => ($request->body) ? $request->body:$comment->body,
        ]);
        return new CommentsResource($comment);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Comment $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment)
    {
        $comment->delete();
        return  response('Comment Deleted',200);
    }
}
