@extends('layouts.admin')

@section('title', 'Pages')
@section('description', 'Pages')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">
                Pages
                <a
                    class="btn btn-primary btn-sm pull-right"
                    data-toggle="modal"
                    data-target="#addLanguageModal"
                    data-backdrop="static"
                ><i class="fa fa-plus"></i> Add</a>
            </h3>
            <table class="table table-bordered table-striped table-hover" id="languages" width="100%">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>URL</th>
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
        $('#languages').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            ajax: '{{ route('admin::getDatatablesPages') }}',
            columns: [
                {data: 'title', name: 'title', orderable: false},
                {data: 'url', name: 'url', orderable: false},
                {data: 'status', name: 'status', orderable: false, width: '5%', 'sClass': 'text-center'},
                {data: 'actions', name: 'actions', orderable: false, width: '5%'},
                {data: 'id', name: 'id', visible: false}                                               
            ],
            order: [[6, 'desc']]
        });
    });
    </script>
@stop