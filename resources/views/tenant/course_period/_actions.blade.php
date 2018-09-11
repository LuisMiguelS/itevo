<div class="btn-group">
<button type="button" class="btn btn-default dropdown-toggle btn-xs" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="margin: 3px">
    <i class="fa fa-eye" aria-hidden="true"></i> <span class="caret"></span>
</button>

@can('tenant-update', $coursePeriod)
<a href="{{ $coursePeriod->url->edit }}" class="btn btn-default btn-xs"  style="margin: 3px">
    <i class="fa fa-pencil" aria-hidden="true"></i>
</a>
@endcan

<ul class="dropdown-menu">
    <li><a href="{{ $coursePeriod->url->resource }}"> Agregar recursos</a></li>
    <li><a href="{{ $coursePeriod->url->schedule }}"> Agregar horarios</a></li>
</ul>

</div>