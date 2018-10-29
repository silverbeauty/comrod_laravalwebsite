<div class="modal fade" id="sendMessageModal">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Send message to {{ $recipient->username }}</h4>        
            </div>
            <form
                action="{{ route('messages::store') }}"
                method="post"
                class="form-ajax"
                data-reload="true"
            >
                {{ csrf_field() }}
                <input type="hidden" name="recipients" value="{{ $recipient->username }}">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Subject</label>
                        <input type="text" name="subject" value="{{ old('subject') }}" class="form-control" placeholder="">
                    </div>
                    <div class="form-group">
                        <label>Message</label>
                        <textarea name="body" class="form-control" rows="5">{{ old('body') }}</textarea>
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
                        data-loading-text="{!! button_loading('Sending...') !!}"
                    >Send</button>
                </div>
            </form>           
        </div>
    </div>
</div>