<?php

namespace App;

class CommentEagerLoad extends Comment
{
    protected $table = 'comments';

    protected $with = ['owner', 'commentable'];
}
