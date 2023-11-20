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
@endsection

@section('content')
  <!-- Hero -->
  <div class="bg-body-light">
    <div class="content content-full">
      <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-2">
        <div class="flex-grow-1">
          <h1 class="h3 fw-bold mb-2">
            Orders
          </h1>
        </div>
        <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
          <ol class="breadcrumb breadcrumb-alt">
            <li class="breadcrumb-item">
              <a class="link-fx" href="javascript:void(0)">Yselling</a>
            </li>
            <li class="breadcrumb-item" aria-current="page">
              Orders
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
              <th>User</th>
              <th>Products</th>
              <th>State</th>
              <th style="width: 15%;">Créé le</th>
              <th style="width: 15%;">Actions</th>
            </tr>
          </thead>
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
            ajax: '{{ route('adm.orders.index') }}',
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
                    data: 'products',
                    name: 'products',
                    class: 'text-center font-size-sm'
                },
                {
                    data: 'state',
                    name: 'state',
                    class: 'text-center font-size-sm'
                },
                {
                    data: 'created_at',
                    name: 'created_at',
                    class: 'text-center font-size-sm'
                },
                {
                    data: 'actions',
                    name: 'actions',
                    class: 'text-center font-size-sm'
                },
            ],
            language: {
                'url': 'https://cdn.datatables.net/plug-ins/1.10.21/i18n/French.json'
            },
        });
    });
</script>
@endsection
