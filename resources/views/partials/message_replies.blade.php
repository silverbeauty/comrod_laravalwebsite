<div class="col-md-8 col-sm-12 col-xs-12">
    <div class="panel panel-default messages" id="messages-pjax-container">
        <div class="panel-heading with-btn">
            <h4 class="panel-title">{{ count($threads) ? $thread->subject : trans('message.messages') }}</h4>
            <div>
                <a
                    href="{{ route('messages::new') }}"
                    class="btn btn-primary btn-sm pjax"
                    data-pjax-container="#messages-pjax-container"
                    data-activable="false"
                    data-deactivable=""
                ><i class="fa fa-plus"></i> {{ trans('message.new_message') }}</a>
            </div>
        </div>
        @if (count($threads))
            <ul class="list-group with-max-height scroll-down">
                <div>
                @foreach ($thread->messages as $message)
                    <?php
                        $owner = $message->user;
                    ?>
                    <li id="message-{{ $message->id }}" class="list-group-item message-reply">
                        <div class="media">
                            <div class="media-left">
                                <a href="{{ $owner->url }}">
                                    <img class="media-object img-circle" src="{{ $owner->small_avatar }}" alt="{{ $owner->username }}" width="50" height="50">
                                </a>
                            </div>
                            <div class="media-body">
                                <h5 class="media-heading">
                                    <a href="{{ $owner->url }}"><b>{{ $owner->username }}</b></a>
                                    @if ($user->id == $owner->id)
                                        <button
                                            type="button"
                                            class="close pull-right confirm-action"
                                            aria-label="Close"
                                            data-confirm-title="{{ trans('message.are_you_sure') }}"
                                            data-confirm-body="{{ trans('message.you_are_about_to_delete_this_message') }}"
                                            data-confirm-button-text="{{ trans('message.yes_delete_it') }}"
                                            data-ajax-data="{{ json_encode(['id' => $message->id]) }}"
                                            data-url="{{ route('messages::deleteMessage') }}"
                                            data-close-on-confirm="false"
                                            data-no-swal-success="true"
                                            data-remove-target="#message-{{ $message->id }}"
                                        ><span aria-hidden="true">&times;</span></button>
                                    @endif
                                </h5>
                                <p class="no-margin">
                                    {!! nl2br(linkify($message->body)) !!}<br/>
                                    <span class="text-muted fs12"><i>{{ $message->created_at->diffForHumans() }}</i></span>
                                </p>
                            </div>
                        </div>
                    </li>
                @endforeach
                </div>
            </ul>
            <form
                action="{{ route('messages::update', ['id' => $thread->id]) }}"
                method="post"
                class="form-ajax"
                data-no-swal-success="true"
                data-add-element="true"
                data-template-id="#messageReplyTemplate"
                data-add-type="insert_after"
                data-add-target=".list-group-item.message-reply:last-child"
            >
                {{ csrf_field() }}
                <input type="hidden" name="_method" value="PUT">
                <div class="panel-footer">                        
                    <div class="form-group">
                        <textarea name="body" class="form-control" rows="3" placeholder="{{ trans('message.write_a_reply') }}"></textarea>
                    </div>
                    <div class="form-group clearfix">
                        <button
                            type="submit"
                            class="btn btn-primary pull-right"
                            data-loading-text="{!! button_loading(trans('message.sending')) !!}"
                        >{{ trans('message.reply') }}</button>
                    </div>                        
                </div>
            </form>
        @else
            <div class="panel-body">{{ trans('message.no_message_available') }}</div>
        @endif
    </div>
</div>