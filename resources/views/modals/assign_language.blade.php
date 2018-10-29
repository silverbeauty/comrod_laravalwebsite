<div class="modal fade" id="assignLanguageModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Assign Language</h4>        
            </div>
            <form
                action="{{ route('admin::postAssignLanguage') }}"
                method="post"
                class="form-ajax"
                data-reload="true"
            >
                <input type="hidden" name="id" value="">
                <div class="modal-body">
                    <div class="form-group">
                        @foreach ($languages->chunk(4) as $languages)
                            <div class="row">
                                @foreach ($languages as $language)
                                    <div class="col-lg-3">
                                        <div class="checkbox">
                                            <label>
                                                <input
                                                    type="checkbox"
                                                    name="languages[]"
                                                    value="{{ $language->name }}"
                                                    id="assign-language-{{ $language->id }}"
                                                >
                                                {{ $language->name }}
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endforeach
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
                        data-loading-text="{!! button_loading('Assigning...') !!}"
                    >Assign</button>
                </div>
            </form>           
        </div>
    </div>
</div>