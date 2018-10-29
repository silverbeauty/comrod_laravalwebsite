<div class="modal fade" id="editLanguageModal">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Edit Language</h4>        
            </div>
            <form
                action="{{ route('admin::postEditLanguage') }}"
                method="post"
                class="form-ajax"
                data-reload="true"
            >
                <input type="hidden" name="id" value="">
                <div class="modal-body">                    
                    <div class="form-group">
                        <label>Abbreviation</label>
                        <input type="text" name="locale" value="{{ old('locale') }}" class="form-control" placeholder="">
                    </div>
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" name="name" value="{{ old('name') }}" class="form-control" placeholder="">
                    </div>
                    <div class="form-group">
                        <label>Country Code <span class="asterisk text-danger">*</span></label>
                        <input type="text" name="country_code" value="{{ old('country_code') }}" class="form-control" placeholder="">
                    </div>
                    <div class="form-group">
                        <label>URL <span class="asterisk text-danger">*</span></label>
                        <input type="text" name="url" value="{{ old('url') }}" class="form-control" placeholder="">
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