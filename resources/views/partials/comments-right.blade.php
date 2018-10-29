<?php $total_comments = count($comments) ?>   

<form
    action="{{ route('api::postWriteComment') }}"
    method="post"
    class="media write-comment-form form-ajax"
    data-no-swal-success="true"
    data-add-element="true"
    data-template-id="#commentTemplate"
    data-add-type="insert_after"
    data-add-target=".Content__Profile__Comments .Content__Heading"
    data-hidable=".hide-if-there-is-comment"
    data-showable=".show-if-there-is-comment"
    data-update-value='{".total-comments-counter": "total_comments"}'
    >
    <div class="media-body">
        <div class="form-group" id="commentFormGroup">
            <textarea name="body" id="comment" rows="2" placeholder="{{ trans('video.comment-this', ['type' => $type]) }}..." class="form-control"></textarea>
            <p class="help-block hidden"></p>
        </div>
        <div class="text-left">
            <input type="hidden" name="content_id" value="{{ $content->id }}">            
            <button
                type="submit"
                class="btn btn-primary btn-rounded btn-sm"
                data-loading-text="{!! button_loading(trans('video.submitting').'...') !!}"
            >&nbsp;&nbsp;{{ trans('video.submit') }}&nbsp;&nbsp;</button>            
        </div>
    </div>
    <div class="media-left">
        <a {{ $signed_in ? 'href='.$user->url.'' : '' }}>
            <img class="media-object img-circle" src="{{ $signed_in ? $user->small_avatar : default_avatar('small') }}" width="60" height="60">
        </a>
    </div>
</form>
    

<h4 class="Content__Heading show-if-there-is-comment {{ $total_comments == 0 ? 'hidden' : '' }}">
    <div class="dropdown right">
        <a data-toggle="dropdown" aria-expanded="false"><i class="fa fa-chevron-circle-down fa-lg"></i></a> &nbsp;&nbsp;
        {{ $comments_sort_types[$comments_sort_type]['text'] }}
        <ul class="dropdown-menu pull-right">
            @foreach ($comments_sort_types as $key => $type)
                @if ($key != $comments_sort_type)
                    <li><a href="?sort={{ $key }}#comments">{{ $type['text'] }}</a></li>
                @endif             
            @endforeach                             
        </ul>
    </div>
    <span class="other-comments">(<span class="total-comments-counter no-padding">{{ $content->total_comments }}</span>) {{ trans('video.other-comments') }}</span>
</h4>
@if ($total_comments)
    @foreach ($comments as $comment)    
        <?php 
            $comment_owner = $comment->owner;
            $comment_id = $comment->id;
            $replies = $comment->replies()->with('owner')->where('parent_id', null)->orderBy('created_at', 'asc')->get();
            $total_replies = count($replies);
            $level = 0;
        ?>
        @if (!is_null($comment_owner))
            <div class="media">
                <div class="media-body">
                    <div class="media">
                        <h4 class="media-heading text-left">
                            <a class="pull-right" href="{{ $comment_owner->url }}">&nbsp;&nbsp;{{ $comment_owner->username }}</a>
                            <span class="date-posted pull-right">{{ $comment->created_at->diffForHumans() }}</span>
                        </h4>
                        <p class="text-left">{!! $comment->body !!}</p>
                        <div class="navbar">
                            <ul class="nav navbar-nav">
                                <li>
                                    <a 
                                        class="show-trigger"
                                        data-collapsable-element="#replyCollapse{{ $comment_id }}"
                                        data-focusable="#replyTextarea{{ $comment_id }}"
                                        data-hidden-element=".reply-{{ $comment_id }}"                                    
                                    >{{ trans('video.reply') }} <i class="fa fa-retweet"></i></a>
                                </li>                            
                                @if ($total_replies)
                                <li>                          
                                    <a 
                                        class="collapse-trigger" 
                                        role="button"
                                        data-toggle="collapse"
                                        data-target="#replyCollapse{{ $comment_id }}"
                                        aria-expanded="false"
                                        aria-controls="replyCollapse{{ $comment_id }}"
                                        id="showRepliesTriggerId{{ $comment_id }}"
                                        data-collapse-text="<i class='fa fa-plus-circle'></i> {{ trans('video.show-replies') }} ({{ $total_replies }})"
                                        data-in-text="<i class='fa fa-minus-circle'></i> {{ trans('video.hide-replies') }} ({{ $total_replies }})"
                                    ><i
                                        class="fa fa-minus-circle"
                                        id="replyCollapseIcon{{ $comment_id }}"
                                    ></i> <span class="text" id="replyCollapseText{{ $comment_id }}">{{ trans('video.hide-replies') }}</span> ({{ $total_replies }})</a>
                                </li>
                                @endif
                                <li>
                                    <div class="dislikess">
                                        <a
                                                class="btn-ajax"
                                                data-url="{{ $comment->like_url }}"
                                                data-ajax-data='{"id": "{{ $comment_id }}"}'
                                                data-callback="likeDislike"
                                                data-loading-text="{!! button_loading() !!}"
                                                data-likes-counter="#commentLikesCounter-{{ $comment_id }}"
                                                data-dislikes-counter="#commentDislikesCounter-{{ $comment_id }}"
                                                title="{{ trans('video.like') }}"
                                        ><i class="fa fa-thumbs-up"></i></a>
                                        <span id="commentLikesCounter-{{ $comment_id }}">{{ $comment->total_likes }}</span>
                                    </div>
                                    <div class="likess">

                                        <a
                                                class="btn-ajax"
                                                data-url="{{ $comment->dislike_url }}"
                                                data-ajax-data='{"id": "{{ $comment_id }}"}'
                                                data-callback="likeDislike"
                                                data-loading-text="{!! button_loading() !!}"
                                                data-dislikes-counter="#commentDislikesCounter-{{ $comment_id }}"
                                                data-likes-counter="#commentLikesCounter-{{ $comment_id }}"
                                                title="{{ trans('video.dislike') }}"
                                        ><i class="fa fa-thumbs-down"></i></a>
                                        <span id="commentDislikesCounter-{{ $comment_id }}">{{ $comment->total_dislikes }}</span>
                                    </div>
                                </li>                           
                            </ul>
                        </div>                    
                    </div>
                    @include('partials.replies-right')
                </div>
                <div class="media-left">
                    <a href="{{ $comment_owner->url }}">
                        <img class="media-object img-circle" alt="64x64" src="{{ $comment_owner->small_avatar }}" width="60" height="60">
                    </a>
                </div>
            </div>
        @endif
    @endforeach
@else
    <div class="text-center hide-if-there-is-comment">{{ trans('video.no-comments-available') }}</div>
@endif