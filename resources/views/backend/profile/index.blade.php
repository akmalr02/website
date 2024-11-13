@extends('layouts.webromadan_backend.master_layout')

@section('css')
@endsection


@section('script_atas')
<script src="{{asset('webromadan/be/js/jquery/jquery.min.js')}}"></script>
<script src="{{asset('webromadan/be/js/vendor/tables/datatables/datatables.min.js')}}"></script>
<script src="{{asset('webromadan/be/js/vendor/tables/datatables/extensions/responsive.min.js')}}"></script>
@endsection

@section('script_bawah')
{{-- <script src="{{asset('webromadan/be/demo/pages/datatables_extension_responsive.js')}}"></script> --}}

<script>
    /* ------------------------------------------------------------------------------
 *
 *  # Responsive extension for Datatables
 *
 *  Demo JS code for datatable_responsive.html page
 *
 * ---------------------------------------------------------------------------- */


// Setup module
// ------------------------------

const DatatableResponsive = function() {


    //
    // Setup module components
    //

    // Basic Datatable examples
    const _componentDatatableResponsive = function() {
        if (!$().DataTable) {
            console.warn('Warning - datatables.min.js is not loaded.');
            return;
        }

        // Setting datatable defaults
        $.extend( $.fn.dataTable.defaults, {
            autoWidth: false,
            responsive: true,
            columnDefs: [{ 
                orderable: false,
                width: 200,
                targets: [ 0 ]
            }],
            dom: '<"datatable-header"fl><"datatable-scroll-wrap"t><"datatable-footer"ip>',
            language: {
                search: '<span class="me-3">Filter:</span> <div class="form-control-feedback form-control-feedback-end flex-fill">_INPUT_<div class="form-control-feedback-icon"><i class="ph-magnifying-glass opacity-50"></i></div></div>',
                searchPlaceholder: 'Type to filter...',
                lengthMenu: '<span class="me-3">Show:</span> _MENU_',
                paginate: { 'first': 'First', 'last': 'Last', 'next': document.dir == "rtl" ? '&larr;' : '&rarr;', 'previous': document.dir == "rtl" ? '&rarr;' : '&larr;' }
            }
        });

        $.ajaxSetup({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });


        // Basic responsive configuration
        $('.datatable-responsive').DataTable({
            autoWidth: true,
            // scrollY: 200,
            // scrollX: true,
            processing: true,
            serverSide: true,
            ajax: "{{ route('users.index') }}",
            columns: [
            { data:'DT_RowIndex', name:'DT_RowIndex', width:'10px',orderable:false,searchable:false},
            { data: 'name', name: 'name' },
            { data: 'email', name: 'email' },
            { data: 'role_name', name: 'role_name' },
            {data: 'opsi',name:'opsi',orderable:false,searchable:false},
            ],
            order: [[0, 'asc']],
        });


    };


    //
    // Return objects assigned to module
    //

    return {
        init: function() {
            _componentDatatableResponsive();
        }
    }
}();


// Initialize module
// ------------------------------

document.addEventListener('DOMContentLoaded', function() {
    DatatableResponsive.init();
});
</script>
@endsection

@section('content')
<h1 class="col-lg m-2">Name:
    <span>{{ $user->name }}</span>
</h1>
<h1 class="col-lg m-2">Email:
    <span>{{ $user->email }}</span></h1> 
@endsection
