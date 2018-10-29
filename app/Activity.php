<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $fillable = ['user_id', 'type', 'sub_type', 'activitable_id', 'activitable_type', 'read'];
    //protected $fillable = ['id', 'user_id', 'type', 'sub_type', 'activitable_id', 'activitable_type', 'read', 'deleted_at', 'created_at', 'updated_at'];

    public function activitable()
    {
        return $this->morphTo();
    }

    public function getActivitableTypeAttribute($value)
    {
        $eagerloadable = [
            'App\Comment',
            'App\CommentReply',
            'App\GCMAlert',            
        ];

        return in_array($value, $eagerloadable) ? $value.'EagerLoad' : $value;
    }
}
