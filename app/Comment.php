<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected  $fillable = ['content', 'user_id', 'post_id', 'comment_parent_id'];
    public function user()
    {
        return $this->belongsTo('App\User');
    }
    public function post()
    {
        return $this->belongsTo('App\Post','post_id');
    }
    public function replies()
    {
        return $this->hasMany('App\Comment', 'comment_parent_id');
    }
    // this is inverse of 1:m between comments and reply
    public function singleComment()
    {
        return $this->belongsTo('App\Comment', 'comment_parent_id');
    }
}
