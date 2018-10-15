<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cog\Contracts\Love\Likeable\Models\Likeable as LikeableContract;
use Cog\Laravel\Love\Likeable\Models\Traits\Likeable;

class Status extends Model implements LikeableContract
{
    use Likeable;

    protected $fillable = [
        'body',
        'user_id',
        'image',
    ];

    protected $hidden = [
        'user_id',
        'update_at',
    ];

    protected $appends = [
        'of_friend',
        'replies_count',
        'likes_count',
        'liked',
    ];

    protected $with = [
        'user',
    ];

    public function getOfFriendAttribute()
    {
        return auth()->check() && auth()->user()->isFriendsWith($this->user);
    }

    public function getRepliesCountAttribute()
    {
        return $this->replies()->count();
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }


    public function replies()
    {
        return $this->hasMany('App\Status', 'parent_id');
    }

    public function scopeTopLevel($query)
    {
        return $query->whereNull('parent_id');
    }
}
