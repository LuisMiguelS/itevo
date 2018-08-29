<div class="dropdown">
    <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
        Acciones
        <span class="caret"></span>
    </button>
    <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
        @can('tenant-update', $coursePeriod)
        <li><a href="{{ $coursePeriod->url->edit }}"> Editar</a></li>
        @endcan
        <li role="separator" class="divider"></li>
        <li><a href="{{ $coursePeriod->url->resource }}"> Agregar recursos</a></li>
        <li><a href="{{ $coursePeriod->url->schedule }}"> Agregar horarios</a></li>
    </ul>
</div>