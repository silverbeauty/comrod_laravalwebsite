<?php
    $content = get_content_by_comment_reply($discussion->activitable);
?>

@if ($content && $content->commentable)
<div class="Comment__Card {{ !$discussion->read ? 'unread' : '' }}">
    <img src="{{ $owner->small_avatar }}" width="60" height="60" class="img-circle">
    <div>
        <h4 class="heading">
            <b>{{ $owner->username }}</b>
            @if ($content->commentable->type == 'video')
                {!! trans('profile.user_replied_to_your_comment_for_the_video') !!}:
            @else
                {!! trans('profile.user_replied_to_your_comment_for_the_photo') !!}:
            @endif
            <a href="{{ $content->commentable->url }}">{{ $content->commentable->title }}</a>
        </h4>
        <div class="body">{!! nl2br($discussion->activitable->body) !!}</div>
        <div class="date">{{ $discussion->created_at->diffForHumans() }}</div>
    </div>
    <div>
        <img src="/images/discussions/icon_1.png" width="40">
    </div>
</div>
@endif