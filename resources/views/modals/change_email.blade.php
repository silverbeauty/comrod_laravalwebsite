<div class="modal fade" id="changeEmailModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Change Email</h4>        
            </div>
            <form
                action="{{ route('account::postChangeEmail') }}"
                method="post"
                class="form-ajax"
                data-reload="true"
            >
                <div class="modal-body">
                    <div class="form-group">
                        <label>New Email</label>
                        <input type="text" name="new_email" value="{{ old('email') }}" class="form-control" placeholder="">
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" name="password" value="" class="form-control" placeholder="">
                        <p class="help-block">To change email you need to enter your {{ trans('app.site_name') }} password.</p>
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
                    >Change Email</button>
                </div>
            </form>           
        </div>
    </div>
</div>