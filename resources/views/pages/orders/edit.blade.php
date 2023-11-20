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
            <div class="block-content block-content-full">
                <!-- DataTables init on table by adding .js-dataTable-full class, functionality is initialized in js/pages/tables_datatables.js -->
                <form method="post" action="{{ route('adm.orders.update', ['order' => $order->id]) }}">
                    @csrf
                    <x-forms.input type="text" label="Nom" :value="$order->user->email" :disabled="true" />
                    <x-forms.input type="text" label="Date" :value="$order->created_at" :disabled="true" />

                    <x-forms.select name="order_state_id" label="State" :options="$states"
                        value="{{ $order->order_state_id }}" error="Le champ state est requis" />

                    <x-forms.button.submit />
                </form>
            </div>

            <!-- END Dynamic Table Full -->
        </div>

        <div class="block block-rounded">
            <div class="block-content block-content-full">
                <p>Produits</p>
                <!-- DataTables init on table by adding .js-dataTable-full class, functionality is initialized in js/pages/tables_datatables.js -->
                <table class="table table-bordered table-striped table-vcenter js-dataTable-full fs-sm"
                    id="DataTables_products">
                    <thead>
                        <tr>
                            <th>Nom</th>
                            <th style="width: 15%;">Quantité</th>
                            <th style="width: 15%;">Actions</th>
                        </tr>
                    </thead>
                </table>
            </div>

            <!-- END Dynamic Table Full -->
        </div>


        <!-- END Page Content -->

        <script>
            $(function() {
                $('#DataTables_products').DataTable({
                    stateSave: true,
                    processing: true,
                    serverSide: true,
                    ajax: '{{ route('adm.orders.products', $order->id) }}',
                    columns: [{
                            data: 'name',
                            name: 'name',
                            class: 'text-center font-size-sm'
                        },
                        {
                            data: 'quantity_order',
                            name: 'quantity_order',
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
