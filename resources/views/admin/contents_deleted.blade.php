@extends('layouts.admin')

@section('title', 'Deleted Contents')
@section('description', 'Deleted Contents')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Deleted Contents</h3>
            <table class="table table-bordered table-striped table-hover" id="contents-table" width="100%">
                <thead>
                    <tr>
                        <th class="text-center" width="25">
                            <input type="checkbox" name="select_all" id="select-all">
                        </th>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Uploader</th>
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
        var table = $('#contents-table').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            ajax: '{{ route('admin::getContentsDeletedApi') }}',
            columnDefs: [ {
                orderable: false,
                'searchable':false,         
                className: 'select-checkbox',
                targets:   0,
                render: function (data, type, full, meta){
                     return '<input type="checkbox" name="id[]" value="' 
                        + $('<div/>').text(data).html() + '">';
                 }
            } ],
            columns: [
                {data: 'id', sClass: 'text-center'},
                {data: 'id', name: 'id'},
                {data: 'title', name: 'title'},
                {data: 'uploader', name: 'uploader'},
                {data: 'type', name: 'type', sClass: 'text-center', orderable: 'false'},
                {data: 'status', name: 'status', orderable: false, width: '5%', sClass: 'text-center'},
                {data: 'actions', name: 'actions', orderable: false, width: '5%'}                
            ], 
            select: {
                style: 'multi'
            },           
            order: [[1, 'desc']]
        });

        // Handle click on "Select all" control
       $('#select-all').on('click', function(){
          // Check/uncheck all checkboxes in the table
          var rows = table.rows({ 'search': 'applied' }).nodes();
          $('input[type="checkbox"]', rows).prop('checked', this.checked);

          $('#contents-table tr').each(function (key, item) {
            $(item).removeClass('selected');

            if (key > 0 && this.checked) {
                $(item).addClass('selected');
            }
          }.bind(this));

          $('#multiple-actions-button').addClass('hidden');

          if (this.checked) {
            $('#multiple-actions-button').removeClass('hidden');
          }
       });       

       $('#contents-table tbody').on('click', 'tr', function(e){
            
            var checkbox = $(this).find('input[type="checkbox"]');

            if (! $(e.target).is('input:checkbox')) {
                checkbox.prop('checked', ! checkbox.prop('checked'));
            }

            $(this).removeClass('selected');

            $('#multiple-actions-button').addClass('hidden');

            if (checkbox.prop('checked')) {
                $(this).addClass('selected');                          
            }

            $('#contents-table input[type="checkbox"]').each(function (key, item) {
                if (item.checked) {
                    $('#multiple-actions-button').removeClass('hidden');
                    return;
                }
            });            
       });

       $('body').on('click', '#multiple-actions-button #delete, #multiple-actions-button #restore', function () {
            var ids = [];

            $('#contents-table tbody input[type="checkbox"]').each(function (key, item) {
                if (item.checked) {
                    ids.push($(item).val());                    
                }
            });

            $('#multiple-actions-button #delete').attr('data-ajax-data', JSON.stringify({id: ids}));
            $('#multiple-actions-button #restore').attr('data-ajax-data', JSON.stringify({id: ids}));
       });

       // Handle click on checkbox to set state of "Select all" control
       $('#contents-table tbody').on('change', 'input[type="checkbox"]', function(){
          // If checkbox is not checked
          if(!this.checked){
             var el = $('#select-all').get(0);
             // If "Select all" control is checked and has 'indeterminate' property
             if(el && el.checked && ('indeterminate' in el)){
                // Set visual state of "Select all" control 
                // as 'indeterminate'
                el.indeterminate = true;
             }
          }
       });

       $('#contents-table_length').prepend(`
            <div id="multiple-actions-button" class="btn-group hidden" style="margin-right: 30px;">
                <button 
                    type="button" 
                    class="btn btn-default dropdown-toggle" 
                    data-toggle="dropdown" 
                    aria-haspopup="true" 
                    aria-expanded="false"
                >
                    Action <span class="caret"></span>
                </button>
                <ul class="dropdown-menu pull-left">
                    <li>
                        <a 
                            id="restore"
                            class="confirm-action" 
                            data-confirm-title="Are you sure?" 
                            data-confirm-body="You are about to restore this content" 
                            data-confirm-button-text="Yes, restore it!" 
                            data-ajax-data="" 
                            data-url="/admin/restore-content" 
                            data-reload="true"
                        >Restore</a>
                    </li>
                    <li>
                        <a 
                            id="delete"
                            class="confirm-action" 
                            data-confirm-title="Are you sure?" 
                            data-confirm-body="You will not able to recover this content once it will be deleted permanently" 
                            data-confirm-button-text="Yes, delete permanently!" 
                            data-ajax-data="" 
                            data-url="/admin/force-delete-content" 
                            data-reload="true"
                        >Delete Permanently</a>                        
                    </li>
                </ul>
            </div>
        `);
    });
    </script>
@stop