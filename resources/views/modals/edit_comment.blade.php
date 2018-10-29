<div class="modal fade" id="editCommentModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Edit Comment</h4>        
            </div>
            <form
                action="{{ route('admin::postEditComment') }}"
                method="post"
                class="form-ajax"
                data-reload="true"
            >
                <input type="hidden" name="id" value="">
                <input type="hidden" name="type" value="">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Comment</label>
                        <textarea name="body" class="form-control"></textarea>
                    </div>                    
                </div>
                <div class="modal-footer">
                    <button
                        type="button"
                        class="btn btn-default"
                        data-dismiss="modal"
                        data-loading-text="Cancel"
                    >Cancel</button>
                    <button
                        type="submit"
                        class="btn btn-primary"
                        data-loading-text="{!! button_loading('Saving...') !!}"
                    >Save</button>
                </div>
            </form>           
        </div>
    </div>
</div>