<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = ['user_id','commentable_id','body','commentable_type'];

    public function commentable()
    {
        return $this->morphTo();
    }

    public function user(){

        return $this->belongsTo('App\User');
    }

    public function comments(){

        return $this->morphMany('App\Comment','commentable');
    }
}
