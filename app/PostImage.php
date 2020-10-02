<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PostImage extends Model
{
    protected $fillable = ['image_path', 'post_id'];
    public function Post()
    {
        return $this->belongsTo('App\Post');
    }
}
