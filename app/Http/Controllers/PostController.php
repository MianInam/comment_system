<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Traits\CommonTrait;
use Illuminate\Http\Request;

class PostController extends Controller
{
    use CommonTrait;

    public function store(Request $request)
    {
        try {
            $validators = Validator($request->all(), [
                'title' => 'required|max:250',
                'content' => 'required|max:1500',
            ]);
            if ($validators->fails()) {
                return $this->sendError($validators->messages(), null);
            }

            $post = Post::create($request->all());
            return $this->sendSuccess('success', $post);

        }
        catch (\Exception $e) {
            return $this->sendError($e->getMessage(), false);
        }
    }

    public function index()
    {
        try {
            $post = Post::with('comments')->orderBy('id','DESC')->get();
            return $this->sendSuccess('success', $post);
        }
        catch (\Exception $e) {
            return $this->sendError($e->getMessage(), false);
        }
    }

    public function show($id)
    {
        try {
            $post = Post::with(['comments.user'])->where('id',$id)->first();
            return $this->sendSuccess('success', $post);
        }
        catch (\Exception $e) {
            return $this->sendError($e->getMessage(), false);
        }
    }
}
