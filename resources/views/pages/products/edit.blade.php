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
      <div class="block-content block-content-full">
        <!-- DataTables init on table by adding .js-dataTable-full class, functionality is initialized in js/pages/tables_datatables.js -->
        <form method="post" action="{{ route('adm.products.update', ['product' => $product->id]) }}">
            @csrf
            <x-forms.input type="text" name="name" label="Nom" placeholder="Nom du produit..." value="{{ $product->name }}" error="Le champ nom est requis" />
            <x-forms.input type="textarea" name="description" label="Description" placeholder="Description du produit..." value="{{ $product->description }}" error="Le champ description est requis" />
            <x-forms.input type="number" name="price" label="Prix" placeholder="999€" value="{{ $product->price }}" error="Le champ prix est requis" />
            <x-forms.select name="category_id" label="Catégorie" :options="$categories" value="{{ $product->category_id }}" error="Le champ catégorie est requis" />
            <x-forms.input type="number" name="quantity" label="Quantité" placeholder="100000" value="{{ $product->quantity }}" error="Le champ quantité est requis" />
            <x-forms.input type="text" name="image" label="Image" placeholder="Image du produit..." value="{{ $product->image }}" error="Le champ image est requis" />
            <x-forms.button.submit />
        </form>
    </div>
    <!-- END Dynamic Table Full -->
  </div>
  <!-- END Page Content -->
@endsection
