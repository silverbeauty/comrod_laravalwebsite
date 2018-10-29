@extends('layouts.admin')

@section('title', 'Localization')
@section('description', 'Localization')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">{{ $lang->name }} Translation</h3>
            <div>
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active">
                        <a
                            data-target="#miscellaneous"
                            id="miscellaneous-tab"
                            role="tab"
                            data-toggle="tab"
                            aria-controls="miscellaneous"
                            aria-expanded="true"
                        >Miscellaneous</a>
                    </li>
                    <li
                        role="presentation"
                    >
                        <a
                            data-target="#content"
                            role="tab"
                            id="content-tab"
                            data-toggle="tab"
                            aria-controls="content"
                            aria-expanded="false"
                        >Content</a>
                    </li>
                </ul><br/>
                <div class="tab-content">
                    <div
                        role="tabpanel"
                        class="tab-pane fade active in"
                        id="miscellaneous"
                        aria-labelledby="miscellaneous-tab"
                    >
                        <table class="table table-bordered table-striped table-hover" id="misc-translation" width="100%"> 
                            <thead>
                                <tr>
                                    <th>
                                        <div class="checkbox-inline">
                                            <label>
                                                <input
                                                    name="not_translated_filter"
                                                    type="checkbox"
                                                    data-url="{{ route('admin::getDatatablesTranslations', ['abbr' => $lang->locale]) }}"
                                                    data-type="misc"
                                                >
                                                Show only items not yet translated in {{ $lang->name }}
                                            </label>
                                        </div>
                                        @can('manage_translations', $user)
                                            <a
                                                class="btn btn-primary btn-xs pull-right"
                                                data-toggle="modal"
                                                data-target="#addTranslationItemModal"
                                                data-backdrop="static"
                                            ><i class="fa fa-plus"></i> Add Item</a>
                                        @endcan
                                    </th>                                
                                </tr>
                            </thead>                    
                        </table>
                    </div>
                    <div
                        role="tabpanel"
                        class="tab-pane fade"
                        id="content"
                        aria-labelledby="content-tab"
                    >
                        <table class="table table-bordered table-striped table-hover" id="content-translation" width="100%">
                            <thead>
                                <tr>
                                    <th>
                                        <div class="checkbox-inline">
                                            <label>
                                                <input
                                                    name="not_translated_filter"
                                                    type="checkbox"
                                                    data-url="{{ route('admin::getDatatablesContentTranslations', ['abbr' => $lang->locale]) }}"
                                                    data-type="content"
                                                >
                                                Show only items not yet translated in {{ $lang->name }}
                                            </label>
                                        </div>                                        
                                    </th>                                
                                </tr>
                            </thead>                    
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section ('external_js')
    <script type="text/javascript">
    $(function () {

        var misc_table = $('#misc-translation').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            ajax: '{{ route('admin::getDatatablesTranslations', ['abbr' => $lang->locale, 'filter' => 'no-filter']) }}',
            columns: [
                {data: 'text', name: 'text', orderable: false},
                {data: 'item', name: 'item', visible: false},
                {data: 'id', name: 'id', visible: false}              
            ],
            order: [[2, 'desc']]
        });

        var content_table = $('#content-translation').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            ajax: '{{ route('admin::getDatatablesContentTranslations', ['abbr' => $lang->locale, 'filter' => 'no-filter']) }}',
            columns: [
                {data: 'content', name: 'content', orderable: false},
                {data: 'title', name: 'title', visible: false},
                {data: 'description', name: 'description', visible: false},
                {data: 'id', name: 'id', visible: false}              
            ],
            order: [[3, 'desc']]
        });

        $('input[name="not_translated_filter"]').click(function () {
            var elem = $(this);
            var url = elem.data('url');
            var type = elem.data('type');

            if (elem.is(':checked')) {
                url = url+'/filter';

                if (type == 'misc') {
                    misc_table.ajax.url(url).load();
                }

                if (type == 'content') {
                    content_table.ajax.url(url).load();
                }
            } else {
                url = url+'/no-filter';

                if (type == 'misc') {
                    misc_table.ajax.url(url).load();
                }

                if (type == 'content') {
                    content_table.ajax.url(url).load();
                }
            }
        });
    });    
    </script>
@stop

@section('modals')
    @include('modals.add_translation_item')
@stop