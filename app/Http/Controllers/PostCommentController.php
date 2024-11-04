<?php

namespace App\Http\Controllers;

use App\Models\PostComment;
use App\Traits\CommonTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostCommentController extends Controller
{
    use CommonTrait;
    public function store(Request $request)
    {
        try {
            $validators = Validator($request->all(), [
                'post_id' => 'required|exists:posts,id',
                'comment' => 'required|max:250',
            ]);
            if ($validators->fails()) {
                return $this->sendError($validators->messages(), null);
            }

            $data = $request->all();
            $data['user_id']=Auth::id();
            $comment = PostComment::create($data);
            $comment['user'] = $comment->user;
            return $this->sendSuccess('success', $comment);

        }
        catch (\Exception $e) {
            return $this->sendError($e->getMessage(), false);
        }
    }
    public function destroy($id)
    {
        try {
            $data = PostComment::find($id);
            if ($data){
                $data->delete();
            }
            return $this->sendSuccess('success', true);

        }
        catch (\Exception $e) {
            return $this->sendError($e->getMessage(), false);
        }
    }
}
