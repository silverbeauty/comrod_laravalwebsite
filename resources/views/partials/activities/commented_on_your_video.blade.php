@if ($discussion->activitable && $discussion->activitable->commentable)
    <div class="Comment__Card {{ !$discussion->read ? 'unread' : '' }}">
        <img src="{{ $owner->small_avatar }}" width="60" height="60" class="img-circle">
        <div>
            <h4 class="heading">
                <b>{{ $owner->username }}</b>
                @if ($discussion->activitable->commentable->type == 'video')
                    {{ trans('profile.user_commented_on_your_video') }}:
                @else
                    {{ trans('profile.user_commented_on_your_photo') }}:
                @endif
                <a href="{{ $discussion->activitable->commentable->url }}">{{ $discussion->activitable->commentable->title }}</a>
            </h4>
            <div class="body">{!! nl2br($discussion->activitable->body) !!}</div>
            <div class="date">{{ $discussion->created_at->diffForHumans() }}</div>
        </div>
        <div>
            <img src="/images/discussions/icon_2.png" width="40">
        </div>
    </div>
@endif