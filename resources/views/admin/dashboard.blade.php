@extends('layouts.admin')

@section('title', 'Dashboard')
@section('description', 'Dashboard')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Dashboard</h3>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">Users Activity</h4>                    
                </div>
                <div class="panel-body">
                    <table class="table table-bordered table-striped table-hover" id="users-activity" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Username</th>
                                <th>Signup</th>
                                <th>Last Login</th>
                                <th>Last Visit</th>
                                <th>Last Last Visit</th>
                                <th>Points</th>
                                <th>Device</th>
                            </tr>
                        </thead>                    
                    </table>
                </div>
            </div>
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
            ajax: '{{ route('admin::getUsersActivity') }}',
            columns: [
                {data: 'id', name: 'id'},
                {data: 'username', name: 'username'},
                {data: 'created_at', name: 'created_at'},
                {data: 'last_login', name: 'last_login'},
                {data: 'last_visit', name: 'last_visit'},
                {data: 'last_last_visit', name: 'last_last_visit'},
                {data: 'points', name: 'points'},
                {data: 'user_agent', name: 'user_agent'}
            ],
            order: [[0, 'desc']]
        });
    });
    </script>
@stop