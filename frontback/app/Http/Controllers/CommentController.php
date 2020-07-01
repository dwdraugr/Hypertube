<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Video;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function index(Video $video)
    {
        $comments = $video->comments;
        foreach ($comments as &$comment) {
            $user = \App\User::find($comment->user_id);
            $comment['user'] = [
                'name' => $user->name,
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'icon' => $user->icon,
            ];
        }
        return $comments;
    }

    public function store(Request $request)
    {
        $validateData = $request->validate([
            'video_id' => 'required|integer',
            'text' => 'required',
        ]);
        Comment::saveNewComment($validateData['video_id'], $validateData['text']);
        return [
            'status' => 'ok',
        ];
    }


}
