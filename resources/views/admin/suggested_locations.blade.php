@extends('layouts.admin')

@section('title', 'Suggested Locations')
@section('description', 'Suggested Locations')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Suggested Locations</h3>
            <table class="table table-bordered table-striped table-hover" id="suggested-locations" width="100%">
                <thead>
                    <tr>
                        <th>Country</th>
                        <th>State</th>
                        <th>City</th>
                        <th>Latitude</th>
                        <th>Longitude</th>
                        <th>User</th>
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
        $('#suggested-locations').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            ajax: '{{ route('admin::getDatatablesSuggestedLocations') }}',
            columns: [
                {data: 'country', name: 'country', orderable: false},
                {data: 'state', name: 'state', orderable: false},
                {data: 'city', name: 'city', orderable: false},
                {data: 'latitude', name: 'latitude', orderable: false},
                {data: 'longitude', name: 'longitude', orderable: false},
                {data: 'user', name: 'user', orderable: false},
                {data: 'status', name: 'status', orderable: false, sClass: 'text-center'},
                {data: 'actions', name: 'actions', orderable: false, width: '5%'},
                {data: 'id', name: 'id', visible: false}                                
            ],
            order: [[8, 'desc']]
        });
    });
    </script>
@stop