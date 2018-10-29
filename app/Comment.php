<?php

namespace App;

use App\Traits\Votable;
use App\Traits\RecordsActivity;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use RecordsActivity, Votable;

    //protected $fillable = ['user_id', 'body', 'ip'];

    protected $fillable = ['id', 'user_id', 'body', 'total_votes', 'total_likes', 'total_dislikes', 'commentable_id', 'commentable_type', 'ip', 'status', 'read', 'created_at', 'updated_at'];

    protected $voteStates = ['up', 'down', 'neutral'];

    protected static $recordEvents = [];

    public static function boot()
    {
        parent::boot();

        static::created(function ($comment) {
            $comment->commentable()->increment('total_comments');
        });

        static::deleted(function ($comment) {
            $comment->deleteReplies();
            $comment->deleteActivities();
        });
    }

    public function commentable()
    {
        return $this->morphTo();
    }

    public function activities()
    {
        return $this->morphMany(Activity::class, 'activitable');
    }

    public function owner()
    {
        return $this->belongsTo(\App\User::class, 'user_id');
    }

    public function replies()
    {
        return $this->hasMany(\App\CommentReply::class, 'comment_id');
    }

    public function addReply(CommentReply $reply)
    {
        return $this->replies()->save($reply);
    }

    public function deleteReplies()
    {
        foreach ($this->replies as $key => $reply) {
            $reply->delete();
        }

        return $this;
    }

    public function deleteActivities()
    {
        return $this->activities()->delete();
    }

    public function getLikeUrlAttribute()
    {
        return route('api::postLikeComment');
    }

    public function getDislikeUrlAttribute()
    {
        return route('api::postDislikeComment');
    }

    public function getWriteReplyUrlAttribute()
    {
        return route('api::postWriteReply');
    }

    public function getUrlAttribute()
    {
        $content = $this->commentable;

        return $content ? $content->url : null;
    }

    public function getTypeAttribute()
    {
        return 'comment';
    }
}
