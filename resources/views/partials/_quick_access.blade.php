@if($period)
    @if( auth()->user()->can('tenant-view', \App\CoursePeriod::class) )
    <li>
        <a href="{{ route('tenant.periods.course-period.index', ['branchOffice' => $branchOffice, 'period' => $period]) }}">
            <i class="fa fa-circle-o text-red"></i> <span>Cursos activos</span>
        </a>
    </li>
    @endif

    @if( auth()->user()->can('tenant-create', \App\Invoice::class) )
    <li>
        <a href="{{ route('tenant.inscription.index', ['branchOffice' => $branchOffice]) }}">
            <i class="fa fa-circle-o text-yellow"></i> <span>Inscripción</span>
        </a>
    </li>
    @endif
@endif