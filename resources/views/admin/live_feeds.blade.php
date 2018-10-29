@extends('layouts.admin')

@section('title', 'Published Live Feeds')
@section('description', 'Published Live Feeds')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Published Live Feeds</h3>
            <table class="table table-bordered table-striped table-hover" id="contents-table" width="100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Type</th>
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
            ajax: '{{ route('admin::getDatatablesPublishedLiveFeeds') }}',
            columns: [
                {data: 'id', name: 'id', width: '7%'},
                {data: 'title', name: 'title'},
                {data: 'type', name: 'type', orderable: false, width: '5%'},
                {data: 'actions', name: 'actions', orderable: false, width: '5%'}                
            ],
            order: [[0, 'desc']]
        });
    });
    </script>
@stop