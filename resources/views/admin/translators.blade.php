@extends('layouts.admin')

@section('title', 'Translators')
@section('description', 'Translators')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <h3 class="page-header clearfix">
                <div class="pull-left">Translators</div>
                <div class="pull-right">
                    <a 
                        class="btn btn-sm btn-primary"
                        data-toggle="modal"
                        data-target="#addTranslatorModal"
                        data-backdrop="static"
                    ><i class="fa fa-plus"></i> Add</a>
                </div>
            </h3>
            <table class="table table-bordered table-striped table-hover" id="translators" width="100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Languages</th>
                        <th>Status</th>
                        <th>Actions</th>                                
                    </tr>
                </thead>                    
            </table>
        </div>
    </div>
@stop

@section ('external_js')
    <script type="text/javascript">
    $(function () {
        $('#translators').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            ajax: '{{ route('admin::getDatatablesTranslators') }}',
            columns: [
                {data: 'id', name: 'id'},
                {data: 'username', name: 'username'},
                {data: 'email', name: 'email'},
                {data: 'languages', name: 'languages'},
                {data: 'status', name: 'status', orderable: false, width: '5%', sClass: 'text-center'},
                {data: 'actions', name: 'actions', orderable: false, width: '5%'}                
            ],
            order: [[0, 'desc']]
        });
    });
    </script>
@stop

@section('modals')
    @include('modals.assign_language')
    @include('modals.add_translator')
    @include('modals.add_translator_filters')
@stop