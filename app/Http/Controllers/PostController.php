<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Post;
use Carbon\Carbon;
use App\Http\Resources\Post as PostResource;
use App\Http\Resources\PostCollection;
use Illuminate\Support\Facades\Redis;

class PostController extends Controller
{
    public function store()
    {
        $data = request()->validate([
            'title'     => 'required',
            'body'      => '',
        ]);

        $post = Post::create($data);



        return new PostResource($post);
    }
    public function index()
    {
        $cache_key = 'posts_all';
        $posts = Redis::get($cache_key);

        if (is_null($posts)) {
            $posts = new PostCollection(Post::all());
            Redis::set($cache_key, $posts->toJson());
        }

        return $posts;
    }
    public function show(Post $post)
    {
        return new PostResource($post);
    }
    public function update(Post $post)
    {
        $data = request()->validate([
            'title' => 'sometimes|required',
            'body' => '',

        ]);
        $post->update($data);
        return new PostResource($post);
    }
}
