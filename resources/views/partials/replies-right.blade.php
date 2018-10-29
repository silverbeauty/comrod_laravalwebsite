<?php
    $level++;
    $reply_wrapper_id = 'reply-'.$comment_id;
    $textarea_id = 'replyTextarea'.$comment_id;
    $reply_form_wrapper_id = 'replyFormWrapper'.$comment_id;
    $reply_collapse_id = 'replyCollapse'.$comment_id;
    $show_replies_trigger_id = 'showRepliesTriggerId'.$comment_id;
    $form_group_id = 'replyFormGroup'.$comment_id;

    if ($level > 1) {
        $textarea_id = 'replyReplyTextarea'.$reply_id;
        $reply_wrapper_id = 'reply-reply-'.$reply_id;
        $reply_form_wrapper_id = 'replyReplyFormWrapper'.$reply_id;
        $reply_collapse_id = 'replyReplyCollapse'.$reply_id;
        $show_replies_trigger_id = 'showRepliesRepliesTriggerId'.$reply_id;
        $comment_owner = $reply_owner;
        //$form_group_id = 'replyReplyFormGroup'.$comment_id;
    }
?>

<div
    id="{{ $reply_collapse_id }}"
    class="collapse replies {{ !$total_replies ? 'hidden hidable-element' : 'in' }} {{ $reply_wrapper_id }}"
    data-collapse-trigger-id="#{{ $show_replies_trigger_id }}"
    data-focusable="#{{ $textarea_id }}"
    data-trigger="#{{ $show_replies_trigger_id }}"    
>
    @foreach ($replies as $key => $reply)
    <?php 
        $reply_owner = $reply->owner;
        $reply_id = $reply->id;        
        $replies = App\CommentReply::with('owner')->where('parent_id', $reply_id)->orderBy('created_at', 'desc')->get();
        $total_replies = count($replies);                       
    ?>
        <div class="media">
            <div class="media-body">
                <div>
                    <h4 class="media-heading text-left">
                        <a class="pull-right" href="{{ $reply_owner->url }}">&nbsp;&nbsp;{{ $reply_owner->username }}</a>
                        <span class="date-posted pull-right">{{ $reply->created_at->diffForHumans() }}</span>
                    </h4>
                    <p class="text-left">{!! $reply->body !!}</p>
                    <div class="navbar">
                        <ul class="nav navbar-nav">
                            <li>
                                <a
                                    class="show-trigger"
                                    data-collapsable-element="#replyReplyCollapse{{ $reply_id }}"
                                    data-focusable="#replyReplyTextarea{{ $reply_id }}"
                                    data-hidden-element=".reply-reply-{{ $reply_id }}"
                                >{{ trans('video.reply') }} <i class="fa fa-retweet"></i></a>
                            </li>
                            @if ($total_replies)
                                <li>
                                    <a 
                                        class="collapse-trigger" 
                                        role="button"
                                        data-toggle="collapse"
                                        data-target="#replyReplyCollapse{{ $reply_id }}"
                                        aria-expanded="false"
                                        aria-controls="replyReplyCollapse{{ $reply_id }}"
                                        id="showRepliesRepliesTriggerId{{ $reply_id }}"
                                        data-collapse-text="<i class='fa fa-plus-circle'></i> Show Replies ({{ $total_replies }})"
                                        data-in-text="<i class='fa fa-minus-circle'></i> Hide Replies ({{ $total_replies }})"
                                    ><i class="fa fa-minus-circle"></i> <span class="text">{{ trans('video.hide-replies') }}</span> ({{ $total_replies }})</a>
                                </li>
                            @endif
                            <li>
                                <div>
                                    <span id="replyDislikesCounter-{{ $reply_id }}">{{ $reply->total_dislikes }}</span> 
                                    <a
                                        class="btn-ajax"
                                        data-url="{{ $reply->dislike_url }}"
                                        data-ajax-data='{"id": "{{ $reply_id }}"}'
                                        data-callback="likeDislike"
                                        data-loading-text="{!! button_loading() !!}"
                                        data-dislikes-counter="#replyDislikesCounter-{{ $reply_id }}"
                                        data-likes-counter="#replyLikesCounter-{{ $reply_id }}"
                                        title="Dislike"
                                    ><i class="fa fa-thumbs-up"></i></a>
                                </div>
                                <div>
                                    <span id="replyLikesCounter-{{ $reply_id }}">{{ $reply->total_likes }}</span> 
                                    <a
                                        class="btn-ajax"
                                        data-url="{{ $reply->like_url }}"
                                        data-ajax-data='{"id": "{{ $reply_id }}"}'
                                        data-callback="likeDislike"
                                        data-loading-text="{!! button_loading() !!}"
                                        data-likes-counter="#replyLikesCounter-{{ $reply_id }}"
                                        data-dislikes-counter="#replyDislikesCounter-{{ $reply_id }}"
                                        title="Like"
                                    ><i class="fa fa-thumbs-down"></i></a>
                                </div>
                            </li>
                        </ul>
                    </div>                    
                </div>
                @include('partials.replies-right')
            </div>
            <div class="media-left">
                <a href="{{ $reply_owner->url }}">
                    <img class="media-object img-circle" alt="40x40" src="{{ $reply_owner->small_avatar }}" width="40" height="40">
                </a>
            </div>
        </div>
    @endforeach
    <div class="media hidden {{ $reply_wrapper_id }} hidable-element" id="{{ $reply_form_wrapper_id }}">
        <form
            action="{{ $comment->write_reply_url }}"
            method="post"
            class="form-ajax"
            data-no-swal-success="true"
            data-add-element="true"
            data-template-id="#replyTemplate"
            data-add-type="insert_before"
            data-add-target="#{{ $reply_form_wrapper_id }}"
        >
            <div class="media-body">
                <div class="form-group" id="{{ $form_group_id }}">
                    <textarea
                        name="body"
                        id="{{ $textarea_id }}"
                        rows="2"
                        placeholder="{{ trans('video.add_your_reply') }}"
                        class="form-control"                                            
                    ></textarea>
                    <p class="help-block hidden"></p>
                </div>
                <div class="text-left">
                    <input type="hidden" name="level" value="{{ $level }}">
                    <input type="hidden" name="comment_id" value="{{ $level == 1 ? $comment_id : $reply_id }}">
                    <a
                        href="{{ $comment_owner->url }}"
                    >{{ $comment_owner->username }}</a>&nbsp;&nbsp;{{ trans('video.to') }}&nbsp;&nbsp;
                    <button
                        type="submit"
                        class="btn btn-primary btn-rounded btn-sm"
                        data-loading-text="{!! button_loading(trans('video.replying').'...') !!}"
                    >&nbsp;&nbsp;{{ trans('video.reply') }}&nbsp;&nbsp;</button>
                </div>
            </div>
            <div class="media-left">
                <a href="#">
                    <img class="media-object img-circle" src="{{ $signed_in ? $user->small_avatar : default_avatar('small') }}" width="40" height="40">
                </a>
            </div>
        </form>
    </div>
</div>