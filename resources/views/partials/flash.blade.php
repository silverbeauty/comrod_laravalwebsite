@if (session()->has('flash_message'))
    <script type="text/javascript">
        $(function () {
            swal({
                title: "{{ session('flash_message.title') }}",
                text: "{{ session('flash_message.body') }}",
                type: "{{ session('flash_message.type') }}",
                timer: 3000,
                showConfirmButton: false
            });
        });
    </script>
@endif