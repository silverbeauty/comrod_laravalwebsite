<script type="text/template" id="commentTemplate">
    <div class="media">
        <div class="media-left">
            <a href="<%- rc.user_profile_url %>">
                <img class="media-object img-circle" alt="64x64" src="<%- rc.avatar %>" width="60" height="60">
            </a>
        </div>
        <div class="media-body">            
            <h4 class="media-heading">
                <a href="<%- rc.user_profile_url %>"><%- rc.username %></a>
                <span class="date-posted"><%- rc.date %></span>
            </h4>
            <p><%- rc.body %></p>
            <div class="navbar">
                <ul class="nav navbar-nav">
                    <li>
                        <a
                            class="show-trigger"
                            data-collapsable-element="#replyCollapse<%- rc.id %>"
                            data-focusable="#replyTextarea<%- rc.id %>"
                            data-hidden-element=".reply-<%- rc.id %>"
                        ><i class="fa fa-retweet"></i> Reply</a>
                    </li>
                    <li>
                        <div>
                            <a
                                class="btn-ajax"
                                data-url="{{ route('api::postLikeComment') }}"
                                data-ajax-data='{"id": "<%- rc.id %>"}'
                                data-callback="likeDislike"
                                data-loading-text="{!! button_loading() !!}"
                                data-likes-counter="#commentLikesCounter<%- rc.id %>"
                                data-dislikes-counter="#commentDislikesCounter<%- rc.id %>"
                                title="Like"
                            ><i class="fa fa-thumbs-up"></i></a> <span id="commentLikesCounter<%- rc.id %>">0</span>
                        </div>
                        
                        <div>
                            <a
                                class="btn-ajax"
                                data-url="{{ route('api::postDislikeComment') }}"
                                data-ajax-data='{"id": "<%- rc.id %>"}'
                                data-callback="likeDislike"
                                data-loading-text="{!! button_loading() !!}"
                                data-dislikes-counter="#commentDislikesCounter<%- rc.id %>"
                                data-likes-counter="#commentLikesCounter<%- rc.id %>"
                                title="Dislike"
                            ><i class="fa fa-thumbs-down"></i></a> <span id="commentDislikesCounter<%- rc.id %>">0</span>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="replies hidden reply-<%- rc.id %> hidable-element">
                <div class="media hidden reply-<%- rc.id %> hidable-element" id="replyFormWrapper<%- rc.id %>">
                    <form
                        action="{{ route('api::postWriteReply') }}"
                        method="post"
                        class="form-ajax"
                        data-no-swal-success="true"
                        data-add-element="true"
                        data-template-id="#replyTemplate"
                        data-add-type="insert_before"
                        data-add-target="#replyFormWrapper<%- rc.id %>"
                        data-close-modal="false"                       
                    >
                        <div class="media-left">
                            <a href="#">
                                <img class="media-object img-circle" alt="40x40" src="<%- rc.avatar %>" width="40" height="40">
                            </a>
                        </div>
                        <div class="media-body">
                            <div class="form-group" id="replyFormGroup<%- rc.id %>">
                                <textarea
                                    name="body"
                                    id="replyTextarea<%- rc.id %>"
                                    rows="2"
                                    placeholder="Add your reply..."
                                    class="form-control"                                            
                                ></textarea>
                                <p class="help-block hidden"></p>
                            </div>
                            <div>
                                <input type="hidden" name="level" value="<%- rc.level %>">
                                <input type="hidden" name="comment_id" value="<%- rc.id %>">
                                <button
                                    type="submit"
                                    class="btn btn-primary btn-rounded btn-sm"
                                    data-loading-text="{!! button_loading('Replying...') !!}"
                                >&nbsp;&nbsp;Reply&nbsp;&nbsp;</button>&nbsp;&nbsp; to
                                <a
                                    href="<%- rc.user_profile_url %>"
                                ><%- rc.username %></a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</script>
<script type="text/template" id="replyTemplate">
    <div class="media">
        <div class="media-left">
            <a href="<%- rc.user_profile_url %>">
                <img class="media-object img-circle" alt="40x40" src="<%- rc.avatar %>" width="40" height="40">
            </a>
        </div>
        <div class="media-body">
            <h4 class="media-heading">
                <a href="<%- rc.user_profile_url %>"><%- rc.username %></a>
                <span class="date-posted"><%- rc.date %></span>
            </h4>
            <p><%- rc.body %></p>
            <div class="navbar">
                <ul class="nav navbar-nav">
                    <li>
                        <a
                            class="show-trigger"
                            data-collapsable-element="#replyReplyCollapse<%- rc.id %>"
                            data-focusable="#replyReplyTextarea<%- rc.id %>"
                            data-hidden-element=".reply-reply-<%- rc.id %>"
                        ><i class="fa fa-retweet"></i> Reply</a>
                    </li>
                    <li>
                        <div>
                            <a
                                class="btn-ajax"
                                data-url="{{ route('api::postLikeReply') }}"
                                data-ajax-data='{"id": "<%- rc.id %>"}'
                                data-callback="likeDislike"
                                data-loading-text="{!! button_loading() !!}"
                                data-likes-counter="#replyLikesCounter-<%- rc.id %>"
                                data-dislikes-counter="#replyDislikesCounter-<%- rc.id %>"
                                title="Like"
                            ><i class="fa fa-thumbs-up"></i></a> <span id="replyLikesCounter-<%- rc.id %>">0</span>
                        </div>
                        
                        <div>
                            <a
                                class="btn-ajax"                                
                                data-url="{{ route('api::postDislikeReply') }}"
                                data-ajax-data='{"id": "<%- rc.id %>"}'
                                data-callback="likeDislike"
                                data-loading-text="{!! button_loading() !!}"
                                data-dislikes-counter="#replyDislikesCounter-<%- rc.id %>"
                                data-likes-counter="#replyLikesCounter-<%- rc.id %>"
                                title="Dislike"
                            ><i class="fa fa-thumbs-down"></i></a> <span id="replyDislikesCounter-<%- rc.id %>">0</span>
                        </div>
                    </li>
                </ul>
            </div>            
            <div class="replies hidden reply-reply-<%- rc.id %> hidable-element">
                <div class="media hidden reply-reply-<%- rc.id %> hidable-element" id="replyReplyFormWrapper<%- rc.id %>">
                    <form
                        action="{{ route('api::postWriteReply') }}"
                        method="post"
                        class="form-ajax"
                        data-no-swal-success="true"
                        data-add-element="true"
                        data-template-id="#replyTemplate"
                        data-add-type="insert_before"
                        data-add-target="#replyReplyFormWrapper<%- rc.id %>"
                        data-close-modal="false"
                    >
                        <div class="media-left">
                            <a href="#">
                                <img class="media-object img-circle" alt="40x40" src="<%- rc.avatar %>" width="40" height="40">
                            </a>
                        </div>
                        <div class="media-body">
                            <div class="form-group" id="replyFormGroup<%- rc.id %>">
                                <textarea
                                    name="body"
                                    id="replyReplayTextarea<%- rc.id %>"
                                    rows="2"
                                    placeholder="Add your reply..."
                                    class="form-control"                                            
                                ></textarea>
                                <p class="help-block hidden"></p>
                            </div>
                            <div>
                                <input type="hidden" name="level" value="<%- rc.level %>">
                                <input type="hidden" name="comment_id" value="<%- rc.id %>">
                                <button
                                    type="submit"
                                    class="btn btn-primary btn-rounded btn-sm"
                                    data-loading-text="{!! button_loading('Replying...') !!}"
                                >&nbsp;&nbsp;Reply&nbsp;&nbsp;</button>&nbsp;&nbsp; to
                                <a
                                    href="<%- rc.user_profile_url %>"
                                ><%- rc.username %></a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</script>