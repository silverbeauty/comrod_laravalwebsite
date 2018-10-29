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
            <textarea name="body" class="form-control" rows="3" placeholder="Write a reply"></textarea>
        </div>
        <div class="form-group clearfix">
            <button
                type="submit"
                class="btn btn-primary pull-right"
                data-loading-text="{!! button_loading('Sending...') !!}"
            >Reply</button>
        </div>                        
    </div>
</form>