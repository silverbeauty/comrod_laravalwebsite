@extends('layouts.admin')

@section('title', 'Reported Contents')
@section('description', 'Reported Contents')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Reported Contents</h3>
            <table class="table table-bordered table-striped table-hover" id="contents-table" width="100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Reporter</th>
                        <th>Reason</th>
                        <th>Message</th>
                        <th>Type</th>
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
        $('#contents-table').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            ajax: '{{ route('admin::getDatatablesReportedContents') }}',
            columns: [
                {data: 'content_id', name: 'content_id'},
                {data: 'title', name: 'title'},
                {data: 'reporter', name: 'reporter'},
                {data: 'reason', name: 'reason'},
                {data: 'message', name: 'message'},
                {data: 'type', name: 'type', sClass: 'text-center', orderable: 'false'},
                {data: 'status', name: 'status', orderable: false, width: '5%', sClass: 'text-center'},
                {data: 'actions', name: 'actions', orderable: false, width: '5%'}                
            ],
            order: [[0, 'desc']]
        });
    });
    </script>
@stop