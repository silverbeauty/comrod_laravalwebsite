<div class="modal fade" id="addTranslationItemModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Add Item ({{ $lang->name }})</h4>        
            </div>
            <form
                action="{{ route('admin::postAddTranslationItem') }}"
                method="post"
                class="form-ajax"
                data-reload="true"
            >
                <input type="hidden" name="locale" value="{{ $lang->locale }}">
                <div class="modal-body">                    
                    <div class="form-group">
                        <label>Group</label>
                        <input type="text" name="group" value="{{ old('group') }}" class="form-control" placeholder="">
                    </div>
                    <div class="form-group">
                        <label>Item Key</label>
                        <input type="text" name="item" value="{{ old('item') }}" class="form-control" placeholder="">
                    </div>
                    <div class="form-group">
                        <label>Text</label>
                        <textarea name="text" class="form-control">{{ old('text') }}</textarea>
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
                        data-loading-text="{!! button_loading('Adding...') !!}"
                    >Add</button>
                </div>
            </form>           
        </div>
    </div>
</div>