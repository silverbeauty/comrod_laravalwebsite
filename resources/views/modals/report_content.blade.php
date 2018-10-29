<div class="modal fade" id="reportContentModal">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">{{ trans('video.report-content') }}</h4>        
            </div>
            <form
                action="{{ route('api::postReportContent') }}"
                method="post"
                class="form-ajax form-horizontal"                
            >
                <input type="hidden" name="content_id" value="">
                <div class="modal-body gutter-5">
                    <div class="form-group">
                        <div class="col-md-12">{{ trans('video.report_content_sentence') }}</div>
                    </div>
                    @if (!$signed_in)
                        <div class="form-group">
                            <label class="col-md-12">{{ trans('app.name') }} <span class="text-primary asterisk">*</span></label>
                            <div class="col-md-12">
                                <input type="text" name="name" value="{{ $signed_in ? $user->username : null }}" class="form-control" placeholder="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-12">{{ trans('app.email') }} <span class="text-primary asterisk">*</span></label>
                            <div class="col-md-12">
                                <input type="text" name="email" value="" class="form-control" placeholder="">
                            </div>
                        </div>
                    @endif
                    <div class="form-group">
                        <label class="col-md-12">{{ trans('app.reasons') }} <span class="text-primary asterisk">*</span></label>
                        <div class="col-md-12">
                            <select name="reason_id" class="chosen-select form-control" data-placeholder="{{ trans('video.select') }}...">
                                <option></option>
                                @foreach (reasons('report_content') as $reason)
                                    <option value="{{ $reason->id }}">{{ $reason->label }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-12">{{ trans('message.message') }} <span class="text-primary asterisk">*</span></label>
                        <div class="col-md-12">
                            <textarea name="message" class="form-control" rows="5"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button
                        type="button"
                        class="btn btn-default"
                        data-dismiss="modal"
                        data-loading-text="{{ trans('app.cancel') }}"
                    >{{ trans('app.cancel') }}</button>
                    <button
                        type="submit"
                        class="btn btn-primary"
                        data-loading-text="{!! button_loading(trans('video.submitting')) !!}"
                    >{{ trans('video.submit') }}</button>
                </div>
            </form>           
        </div>
    </div>
</div>