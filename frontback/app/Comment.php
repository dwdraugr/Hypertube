<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Comment extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function video()
    {
        return $this->belongsTo(Video::class);
    }

    public static function saveNewComment(int $videoId, string $text)
    {
        $comment = new Comment;
        $comment->video_id = $videoId;
        $comment->user_id = Auth::id();
        $comment->text = $text;
        $comment->save();
    }
}
