@extends('layouts.admin')

@section('title', 'Roles & Permissions')
@section('description', 'Roles & Permissions')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Roles & Permissions</h3>
            @foreach ($roles->chunk(2) as $chunked_roles)
                <div class="row">
                    @foreach ($chunked_roles as $role)
                        <div class="col-lg-6">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title">{{ $role->label }}</h4>
                                </div>
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <h5 class="no-margin-top"><b>Permissions</b></h5>                                    
                                            @foreach ($permissions as $permission)                                                
                                                <div class="checkbox">
                                                    <label>
                                                        <input
                                                            type="checkbox"
                                                            name="permissions[]"
                                                            value="{{ $permission->id }}"
                                                            class="checkbox-ajax"
                                                            data-url="{{ route('admin::postEditRolePermission') }}"
                                                            data-ajax-data='{"role_id": {{ $role->id }}, "permission_id": {{ $permission->id }}, "remove": true}'
                                                            {{ $role->hasPermission($permission->name) ? 'checked' : '' }}
                                                        >
                                                        {{ $permission->label }} <i class="fa fa-spinner fa-pulse hidden"></i>
                                                    </label>
                                                </div>                                                
                                            @endforeach
                                        </div>
                                        <div class="col-lg-6">
                                            <h5 class="no-margin-top"><b>Users</b></h5>
                                            <?php $role_users = $role->users; ?>
                                            @if (count($role_users))
                                                <table class="table table-bordered">
                                                    @foreach ($role_users as $role_user)
                                                        <tr>
                                                            <td>
                                                                <a href="{{ $role_user->url }}">{{ $role_user->username }}</a>
                                                            </td>
                                                            <td class="text-center">
                                                                <a
                                                                    class="confirm-action"
                                                                    data-confirm-title="Are you sure?"
                                                                    data-confirm-body="You are about to delete this role from {{ $role_user->username }}"
                                                                    data-confirm-button-text="Yes, delete it"
                                                                    data-url="{{ route('admin::postEditUserRole') }}"
                                                                    data-ajax-data='{"user_id": {{ $role_user->id }}, "role_id": {{ $role->id }}, "remove": true}'
                                                                    data-reload="true"
                                                                >Delete</a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </table>
                                            @else
                                                <div class="text-muted">No users assign</div>
                                            @endif                                    
                                        </div>
                                    </div>                                    
                                </div>
                            </div>
                        </div>                        
                    @endforeach
                </div>
            @endforeach
        </div>
    </div>
@stop