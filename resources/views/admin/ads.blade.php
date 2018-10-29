@extends('layouts.admin')

@section('title', 'Ads')
@section('description', 'Ads')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">
                Ads
                <a
                    class="btn btn-primary btn-sm pull-right"
                    data-toggle="modal"
                    data-target="#addAdModal"
                    data-backdrop="static"
                ><i class="fa fa-plus"></i> Add</a>
            </h3>
            <table class="table table-bordered table-striped table-hover" id="languages" width="100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Label</th>
                        <th>Code</th>
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
            ajax: '{{ route('admin::getDatatablesAds') }}',
            columns: [
                {data: 'id', name: 'id', orderable: true},
                {data: 'label', name: 'label', orderable: false},
                {data: 'code', name: 'code', orderable: false},
                {data: 'status', name: 'status', orderable: false, width: '5%', 'sClass': 'text-center'},
                {data: 'actions', name: 'actions', orderable: false, width: '5%'},                                                               
            ],
            order: [[0, 'desc']]
        });
    });
    </script>
@stop

@section('modals')
    @include('modals.edit_ad')
    @include('modals.add_ad')
@stop