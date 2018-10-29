<div class="modal fade" id="addTranslatorFiltersModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Filters</h4>        
            </div>
            <form
                action="{{ route('admin::postAddTranslatorFilters') }}"
                method="post"
                class="form-ajax"
                data-reload="true"
            >
                <input type="hidden" name="id" value="">
                <div class="modal-body">
                    <div class="form-group">
                        <p>Exclude this translator from translating contents from following countries. </p>
                        @foreach ($countries->chunk(4) as $countries)
                            <div class="row">
                                @foreach ($countries as $country)
                                    <div class="col-lg-3">
                                        <div class="checkbox">
                                            <label>
                                                <input
                                                    type="checkbox"
                                                    name="country_codes[]"
                                                    value="{{ $country->code }}"
                                                    id="exclude-country-{{ $country->code }}"
                                                >
                                                {{ $country->name }}
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
                        data-loading-text="{!! button_loading('Saving...') !!}"
                    >Save</button>
                </div>
            </form>           
        </div>
    </div>
</div>