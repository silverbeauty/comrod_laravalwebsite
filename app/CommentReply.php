<?php

namespace App;

use App\Traits\Votable;
use App\Traits\RecordsActivity;
use Illuminate\Database\Eloquent\Model;

class CommentReply extends Model
{
    use RecordsActivity, Votable;

    //protected $fillable = ['user_id', 'comment_id', 'body', 'ip'];

    protected $fillable = ['id', 'user_id', 'comment_id', 'body', 'total_votes', 'total_likes', 'total_dislikes', 'ip', 'status', 'parent_id', 'read', 'created_at', 'updated_at'];

    protected static $recordEvents = [];

    public static function boot()
    {
        parent::boot();

        static::deleted(function ($reply) {
            $reply->deleteActivities();
        });
    }

    public function activities()
    {
        return $this->morphMany(Activity::class, 'activitable');
    }

    public function owner()
    {
        return $this->belongsTo(\App\User::class, 'user_id');
    }    

    public function comment()
    {
        return $this->belongsTo(\App\Comment::class, 'comment_id');
    }

    public function parent()
    {
        return $this->belongsTo(\App\CommentReply::class, 'parent_id');
    }

    public function replies()
    {
        return $this->hasMany(\App\CommentReply::class, 'parent_id');
    }

    public function addReply(CommentReply $reply)
    {
        return $this->replies()->save($reply);
    }

    public function deleteActivities()
    {
        return $this->activities()->delete();
    }

    public function getLikeUrlAttribute()
    {
        return route('api::postLikeReply');
    }

    public function getDislikeUrlAttribute()
    {
        return route('api::postDislikeReply');
    }    

    public function getUrlAttribute()
    {
        $comment = $this->getParentComment($this->id);
        $content = $comment->commentable;

        return $content ? $content->url : null;
    }

    public function getParentComment($id)
    {
        $reply = CommentReply::findOrFail($id);

        if (is_null($reply->comment_id)) {//dd($reply->id);
            return $this->getParentComment($reply->parent_id);
        }

        return $reply->comment;
    }

    public function getTypeAttribute()
    {
        return 'reply';
    }
}
