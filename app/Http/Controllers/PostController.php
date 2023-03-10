<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostDetailResource;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::all();
        // return response()->json(['data' => $posts]);
        return PostResource::collection($posts->loadMissing(['writer:id,username', 'comments:id,post_id,user_id,comments_content']));
    }

    public function show($id)
    {
        $posts = Post::with('writer:id,username')->findOrFail($id);
        // return response()->json(['data' => $posts]);
        // return new PostDetailResource($posts);
        return new PostDetailResource($posts->loadMissing(['writer:id,username', 'comments:id,post_id,user_id,comments_content']));
    }

    public function store(Request $request)
    {
        
        $validated = $request->validate([
            'title' => 'required|max:255',
            'news_con' => 'required',
        ]);

        $filedata = null;
        if($request->file){
            // Disini untuk upload file
            $filename = $this->generateRandomString();
            $extension = $request->file->extension();

            Storage::putFileAs('img', $request->file,  $filename.'.'.$extension);
            $filedata = $filename.'.'.$extension;
            
        }
        $request['image'] = $filedata;
        $request['author'] = Auth::user()->id;
        $post = Post::create($request->all());

        return new PostDetailResource($post->loadMissing('writer:id,username'));
    }

    public function update(Request $request, $id)
    {
        // dd('ini update');
        $request->validate([
            'title' => 'required|max:255',
            'news_con' => 'required',
        ]);

        $post = Post::findOrFail($request->id);
        $post->update($request->all());

        return new PostDetailResource($post->loadMissing('writer:id,username'));
        
    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        $post->delete();

        return new PostDetailResource($post->loadMissing('writer:id,username'));
    }

    function generateRandomString($length = 30) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}