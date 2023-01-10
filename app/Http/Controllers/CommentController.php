<?php

namespace App\Http\Controllers;

use App\Http\Resources\commentResource;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    function store(Request $request)
    {
        // $post_id = $request->post_id;
        $request->validate([
            'post_id' => 'required|exists:posts,id',
            'comments_content' => 'required',
        ]);

        $request['user_id'] = auth()->user()->id;
        $comment = Comment::create($request->all());

        // return response()->json($comment->loadMissing(['commentator']));
        return new commentResource($comment->loadMissing(['commentator:id,username','commentOnPost:id,title']));
    }

    function update(Request $request, $id)
    {
        $request->validate([
            'comments_content' => 'required',
        ]);

        // $comment = Comment::update($request->only('comments_content'));
        $comment = Comment::findOrFail($id); 
        $comment->update($request->only('comments_content'));

        return new commentResource($comment->loadMissing(['commentator:id,username','commentOnPost:id,title']));
    }

    public function destroy($id)
    {
        $comment = Comment::findOrFail($id);
        $comment->delete();

        return new commentResource($comment->loadMissing(['commentator:id,username','commentOnPost:id,title']));
    }
}
