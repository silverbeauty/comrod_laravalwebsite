@extends('layouts.admin')

@section('title', 'Manage Users')
@section('description', 'Manage Users')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Manage Users</h3>
            <table class="table table-bordered table-striped table-hover" id="users-activity" width="100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Signup</th>
                        <th>IP</th>
                        <th>Status</th>
                        <th>Roles</th>
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
        $('#users-activity').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            ajax: '{{ route('admin::getUsersApi') }}',
            columns: [
                {data: 'id', name: 'id'},
                {data: 'username', name: 'username'},
                {data: 'email', name: 'email'},
                {data: 'created_at', name: 'created_at', sClass: 'text-center'},
                {data: 'registration_ip', name: 'registration_ip', sClass: 'text-center'},
                {data: 'status', name: 'status', orderable: false, width: '5%', sClass: 'text-center'},
                {data: 'roles', name: 'roles', orderable: false, sClass: 'text-center'},
                {data: 'actions', name: 'actions', orderable: false, width: '5%'}                
            ],
            order: [[0, 'desc']]
        });
    });
    </script>
@stop