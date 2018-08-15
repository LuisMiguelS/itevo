<div class="dropdown">
    <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
        Acciones
        <span class="caret"></span>
    </button>
    <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
        @can('tenant-update', $period)
        <li><a href="{{ route('tenant.promotions.periods.edit', [
        'branchOffice' => request('branchOffice'),
        'promotion' => request('promotion'),
        'period' => $period
        ]) }}"> Editar</a></li>
        @endcan
    </ul>
</div>