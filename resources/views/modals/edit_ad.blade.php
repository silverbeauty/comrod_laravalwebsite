<div class="modal fade" id="editAdModal">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Edit Ad Code</h4>        
            </div>
            <form
                action="{{ route('admin::postEditAd') }}"
                method="post"
                class="form-ajax"
                data-reload="true"
            >
                <input type="hidden" name="id" value="">
                <div class="modal-body">                    
                    <div class="form-group">
                        <label>Label</label>
                        <input type="text" name="label" value="{{ old('label') }}" class="form-control" placeholder="">
                    </div>
                    <div class="form-group">
                        <label>Code</label>
                        <textarea name="code" class="form-control" rows="5">{{ old('code') }}</textarea>
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