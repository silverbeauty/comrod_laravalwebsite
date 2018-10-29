@extends('layouts.admin')

@section('title', 'Comments')
@section('description', 'Comments')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Comments</h3>
            <table class="table table-bordered table-striped table-hover" id="comments" width="100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Comment</th>
                        <th>User</th>
                        <th>Date</th>
                        <th>Actions</th>                                
                    </tr>
                </thead>                    
            </table>
        </div>
    </div>
@stop

@section('modals')
    @include('modals.edit_comment')
@stop

@section ('external_js')
    <script type="text/javascript">
    $(function () {
        $('#comments').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            ajax: '{{ route('admin::getDatatablesComments') }}',
            columns: [
                {data: 'id', name: 'id'},
                {data: 'body', name: 'body'},
                {data: 'user', name: 'user', width: '15%'},
                {data: 'created_at', name: 'created_at', sClass: 'text-center', width: '12%'},
                {data: 'actions', name: 'actions', orderable: false, width: '5%'}                
            ],
            order: [[3, 'desc']]
        });
    });
    </script>
@stop