<script src="{{ asset('client/assets/js/vendor/vendor.min.js') }}"></script>
<script src="{{ asset('client/assets/js/plugins/plugins.min.js') }}"></script>

<!-- Main Activation JS -->
<script src="{{ asset('client/assets/js/main.js') }}"></script>


{{-- js thêm --}}


<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>{{-- link thông báo --}}
<script>
    @if (session('status_succeed'))
        toastr.success("{{ session('status_succeed') }}", {
            timeOut: 3000
        });
    @elseif (session('status_failed'))
        toastr.error("{{ session('status_failed') }}", {
            timeOut: 3000
        });
    @endif
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{ asset('js/admin/change.js') }}"></script>
<!-- Tải jQuery trước -->
{{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}
