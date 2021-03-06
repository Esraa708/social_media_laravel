<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected  $fillable = ['post_title', 'post_content', 'user_id'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
    public function images()
    {
        return $this->hasMany('App\PostImage');
    }
    public function comments()
    {
        return $this->hasMany('App\Comment','post_id');
    }
}
