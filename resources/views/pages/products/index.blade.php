@extends('layouts.backend')

@section('css')
  <!-- Page JS Plugins CSS -->
  <link rel="stylesheet" href="{{ asset('js/plugins/datatables-bs5/css/dataTables.bootstrap5.min.css') }}">
  <link rel="stylesheet" href="{{ asset('js/plugins/datatables-buttons-bs5/css/buttons.bootstrap5.min.css') }}">
@endsection

@section('js')
  <!-- jQuery (required for DataTables plugin) -->
  <script src="{{ asset('js/lib/jquery.min.js') }}"></script>
  <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js" crossorigin="anonymous"
        referrerpolicy="no-referrer"></script>
{{--
  <!-- Page JS Plugins -->
  <script src="{{ asset('js/plugins/datatables/jquery.dataTables.min.js') }}"></script>
  <script src="{{ asset('js/plugins/datatables-bs5/js/dataTables.bootstrap5.min.js') }}"></script>
  <script src="{{ asset('js/plugins/datatables-buttons/dataTables.buttons.min.js') }}"></script>
  <script src="{{ asset('js/plugins/datatables-buttons-bs5/js/buttons.bootstrap5.min.js') }}"></script>
  <script src="{{ asset('js/plugins/datatables-buttons-jszip/jszip.min.js') }}"></script>
  <script src="{{ asset('js/plugins/datatables-buttons-pdfmake/pdfmake.min.js') }}"></script>
  <script src="{{ asset('js/plugins/datatables-buttons-pdfmake/vfs_fonts.js') }}"></script>
  <script src="{{ asset('js/plugins/datatables-buttons/buttons.print.min.js') }}"></script>
  <script src="{{ asset('js/plugins/datatables-buttons/buttons.html5.min.js') }}"></script> --}}

  <!-- Page JS Code -->
  {{-- @vite(['resources/js/pages/datatables.js']) --}}
@endsection

@section('content')
  <!-- Hero -->
  <div class="bg-body-light">
    <div class="content content-full">
      <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-2">
        <div class="flex-grow-1">
          <h1 class="h3 fw-bold mb-2">
            Products
          </h1>
        </div>
        <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
          <ol class="breadcrumb breadcrumb-alt">
            <li class="breadcrumb-item">
              <a class="link-fx" href="javascript:void(0)">Yselling</a>
            </li>
            <li class="breadcrumb-item" aria-current="page">
              Products
            </li>
          </ol>
        </nav>
      </div>
    </div>
  </div>
  <!-- END Hero -->

  <!-- Page Content -->
  <div class="content">

    <!-- Dynamic Table Full -->
    <div class="block block-rounded">
      {{-- <div class="block-header block-header-default">
        <h3 class="block-title">
          Dynamic Table <small>Full</small>
        </h3>
      </div> --}}
      <div class="block-content block-content-full">
        <!-- DataTables init on table by adding .js-dataTable-full class, functionality is initialized in js/pages/tables_datatables.js -->
        <table class="table table-bordered table-striped table-vcenter js-dataTable-full fs-sm" id="DataTables_Table_1">
          <thead>
            <tr>
              <th class="text-center" style="width: 80px;">#</th>
              <th>Name</th>
              <th class="d-none d-sm-table-cell" style="width: 30%;">Price</th>
              <th style="width: 15%;">Quantity</th>
              <th style="width: 15%;">Category</th>
              <th style="width: 15%;">Sold</th>
            </tr>
          </thead>
          {{-- <tbody>
            @for ($i = 1; $i < 21; $i++)
              <tr>
                <td class="text-center">{{ $i }}</td>
                <td class="fw-semibold">
                  <a href="javascript:void(0)">John Doe</a>
                </td>
                <td class="d-none d-sm-table-cell">
                  client{{ $i }}<span class="text-muted">@example.com</span>
                </td>
                <td class="text-muted">
                  {{ rand(2, 10) }} days ago
                </td>
              </tr>
            @endfor
          </tbody> --}}
        </table>
      </div>
    </div>
    <!-- END Dynamic Table Full -->
  </div>
  <!-- END Page Content -->

  <script>
    $(function() {
        $('#DataTables_Table_1').DataTable({
            stateSave: true,
            processing: true,
            serverSide: true,
            ajax: '{{ route('adm.products.index') }}',
            columns: [{
                    data: 'id',
                    name: 'id',
                    class: 'text-center font-size-sm'
                },
                {
                    data: 'name',
                    name: 'name',
                    class: 'text-center font-size-sm'
                },
                {
                    data: 'price',
                    name: 'price',
                    class: 'text-center font-size-sm'
                },
                {
                    data: 'quantity',
                    name: 'quantity',
                    class: 'text-center font-size-sm'
                },
                {
                    data: 'category',
                    name: 'category',
                    class: 'text-center font-size-sm'
                },
                {
                    data: 'orders',
                    name: 'orders',
                    class: 'text-center font-size-sm'
                },
                // {
                //     data: 'phone',
                //     name: 'phone',
                //     class: 'text-center font-size-sm'
                // },
                // {
                //     data: 'created_at',
                //     name: 'created_at',
                //     class: 'text-center font-size-sm'
                // },
                // {
                //     data: 'locked',
                //     name: 'locked',
                //     class: 'text-center font-size-sm'
                // },
                // {
                //     data: 'actions',
                //     name: 'actions',
                //     class: 'text-center font-size-sm'
                // },
            ],
            language: {
                'url': 'https://cdn.datatables.net/plug-ins/1.10.21/i18n/French.json'
            },
        });
    });
</script>
@endsection
