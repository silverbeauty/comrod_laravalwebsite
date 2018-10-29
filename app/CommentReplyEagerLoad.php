<?php

namespace App;

class CommentReplyEagerLoad extends CommentReply
{
    protected $table = 'comment_replies';

    protected $with = ['owner'];
}
