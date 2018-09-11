@can('tenant-update', $period)
    <a href="{{
        route('tenant.promotions.periods.edit', [
        'branchOffice' => request('branchOffice'),
        'promotion' => request('promotion'),
        'period' => $period
        ]) }}"
       class="btn btn-default btn-xs">
        <i class="fa fa-pencil" aria-hidden="true"></i>
    </a>
@endcan