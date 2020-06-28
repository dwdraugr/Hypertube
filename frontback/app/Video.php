<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Video extends Model
{
    public $timestamps = false;

    public static function saveNewVideo(\stdClass $video)
    {
        if (Video::where('yts_id', $video->id)->first() !== null)
            return;
        $element = new Video;
        $element->yts_id = $video->id;
        $element->imdb_code = $video->imdb_code;
        $element->title = $video->title;
        $element->year = $video->year;
        $element->rating = $video->rating;
        $element->summary = $video->description_intro;
        $element->image = $video->large_cover_image;
        $element->save();
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
