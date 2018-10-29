<div class="modal fade" id="addTranslatorModal">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Add Translator</h4>        
            </div>
            <form
                action="{{ route('admin::postAddTranslator') }}"
                method="post"
                class="form-ajax"
                data-reload="true"
            >
                <div class="modal-body">
                    <div class="form-group">
                        <label>First Name</label>
                        <input type="text" name="first_name" value="" class="form-control" placeholder="">      
                    </div>
                    <div class="form-group">
                        <label>Last Name</label>
                        <input type="text" name="last_name" value="" class="form-control" placeholder="">      
                    </div>
                    <div class="form-group">
                        <label>Username</label>
                        <input type="text" name="username" value="" class="form-control" placeholder="">
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="text" name="email" value="" class="form-control" placeholder="">
                    </div>                    
                    <div class="form-group">
                        <label>Languages</label>
                        @foreach ($languages->chunk(2) as $languages)
                            <div class="row">
                                @foreach ($languages as $language)
                                    <div class="col-lg-3">
                                        <div class="checkbox">
                                            <label>
                                                <input
                                                    type="checkbox"
                                                    name="languages[]"
                                                    value="{{ $language->name }}"                                                    
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
                        data-loading-text="{!! button_loading('Adding...') !!}"
                    >Add</button>
                </div>
            </form>           
        </div>
    </div>
</div>