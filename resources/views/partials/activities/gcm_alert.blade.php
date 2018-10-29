<div class="Comment__Card {{ !$discussion->read ? 'unread' : '' }}">
    <img src="{{ $owner->small_avatar }}" width="60" height="60" class="img-circle">
    <div>
        <h4 class="heading">
            <b>{{ $owner->username }}</b> {{ trans('profile.user_sent_you_a_friendlies_alert') }}
        </h4>
        <div class="body">{!! nl2br($discussion->activitable->body) !!}</div>
        <div class="date">{{ $discussion->created_at->diffForHumans() }}</div>
    </div>
    <div>
        <span class="fa-stack fa-lg">
            <i class="fa fa-circle fa-stack-2x text-primary"></i>
            <i class="fa fa-bell-o fa-stack-1x fa-inverse"></i>
        </span>
    </div>
</div>