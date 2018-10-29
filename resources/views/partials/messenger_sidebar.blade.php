@if (count($threads))
    <div class="col-md-4 col-sm-12 col-xs-12 message-sidebar">                
        <div class="panel panel-default">
            <div class="panel-heading"><h4 class="panel-title">{{ trans('message.conversations') }}</h4></div>
            <div class="list-group with-max-height">
                @foreach ($threads as $key => $thread)
                    <?php
                        $message = $thread->latest_message;
                        $owner = $message->user;
                    ?>
                    <a
                        href="{{ route('messages::show', ['id' => $thread->id]) }}"
                        class="list-group-item pjax {{ $thread->id == $thread_id ? 'active' : '' }}"
                        data-pjax-container="#messages-pjax-container"
                        data-activable="true"
                        data-scroll="bottom"
                        data-scroll-target="#replies"
                        id="conversation-{{ $thread->id }}"                     
                    >
                        <div class="media">
                            <div class="media-left">
                                <img class="media-object img-circle" src="{{ $owner->small_avatar }}" alt="{{ $owner->username }}" width="50" height="50">
                            </div>
                            <div class="media-body">
                                <h5 class="media-heading">
                                    <b>{{ $owner->username }}</b>
                                    <button
                                        type="button"
                                        class="close pull-right confirm-action"
                                        aria-label="Close"
                                        data-confirm-title="{{ trans('message.are_you_sure') }}"
                                        data-confirm-body="{{ trans('message.you_are_about_to_delete_this_conversation') }}"
                                        data-confirm-button-text="{{ trans('message.yes_delete_it') }}"
                                        data-ajax-data="{{ json_encode(['id' => $thread->id]) }}"
                                        data-url="{{ route('messages::deleteThread') }}"
                                        data-close-on-confirm="false"
                                        data-no-swal-success="true"
                                        data-remove-target="#conversation-{{ $thread->id }}"
                                    ><span aria-hidden="true">&times;</span></button>
                                </h5>
                                <p class="no-margin">
                                    {{ strlen($message->body) > 20 ? substr($message->body, 0, 20).'...' : $message->body }}<br/>
                                    <span class="text-muted fs12"><i>{{ $message->created_at->diffForHumans() }}</i></span>
                                </p>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>                
    </div>
@endif