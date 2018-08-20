@if($period)
    <li>
        <a href="{{ route('tenant.periods.course-period.index', ['branchOffice' => $branchOffice, 'period' => $period]) }}">
            <i class="fa fa-circle-o text-red"></i> <span>Cursos activos</span>
        </a>
    </li>
@endif

<li><a href="#"><i class="fa fa-circle-o text-yellow"></i> <span>Warning</span></a></li>
<li><a href="#"><i class="fa fa-circle-o text-aqua"></i> <span>Information</span></a></li>
