<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReportedContent extends Model
{
    use SoftDeletes;

    protected $fillable = ['content_id', 'user_id', 'name', 'email', 'reason_id', 'message', 'ip'];

    public function content()
    {
        return $this->belongsTo(Content::class, 'content_id');
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function reason()
    {
        return $this->belongsTo(Reason::class, 'reason_id')->whereType('report_content');
    }
}
