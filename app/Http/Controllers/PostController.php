<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostDetailResource;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::all();
        // return response()->json(['data' => $posts]);
        return PostResource::collection($posts);
    }

    public function show($id)
    {
        $posts = Post::with('writer:id,username')->findOrFail($id);
        // return response()->json(['data' => $posts]);
        return new PostDetailResource($posts);
    }

    public function show2($id)
    {
        $posts = Post::findOrFail($id);
        // return response()->json(['data' => $posts]);
        return new PostDetailResource($posts);
    }
}