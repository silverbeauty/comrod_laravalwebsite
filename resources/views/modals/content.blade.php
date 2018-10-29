<div
    class="modal fade resize"
    id="contentModal"
    data-attributes="{{ json_encode([
        'clearOnClose' => true
    ]) }}"
>
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="close hidden" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <div class="text-center loading">{!! button_loading(trans('home.loading')) !!}...</div>
                <div class="clearable" id="pjaxModalContentContainer"></div>
            </div>
        </div>
    </div>
</div>