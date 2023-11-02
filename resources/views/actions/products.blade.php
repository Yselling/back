<a class="btn btn-sm btn-alt-secondary" href="{{ route('adm.products.edit', ['product' => $id]) }}" data-toggle="tooltip"
    title="Modifier">
    <i class="fa fa-fw fa-edit"></i>
</a>

{{-- @if ($locked_at == null)
    <a class="btn btn-sm btn-alt-danger delete" href="{{ route('adm.users.lock', ['id' => $id]) }}" data-toggle="tooltip"
        title="Bloquer">
        <i class="fa fa-fw fa-lock"></i>
    </a>
@else
    <a class="btn btn-sm btn-alt-success" href="{{ route('adm.users.unlock', ['id' => $id]) }}" data-toggle="tooltip"
        title="Débloquer">
        <i class="fa fa-fw fa-unlock"></i>
    </a>
@endif --}}
