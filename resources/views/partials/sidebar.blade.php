@can('tenant-view', \App\BranchOffice::class)
    <li class="opened">
        <a href="{{ route('tenant.dashboard', $branchOffice) }}">
            <i class="fas fa-home"></i>
            <span class="title">Dashboard</span>
        </a>
    </li>
@endcan

<li class="has-sub">
    <a href="#">
        <i class="fa fa-school"></i>
        <span class="title">Aulas</span>
    </a>
    <ul>
        @can('tenant-view', \App\Classroom::class)
        <li>
            <a href="{{ route('tenant.classrooms.index', $branchOffice) }}">
                <span class="title">Todas las aulas</span>
            </a>
        </li>
        @endcan

        @can('tenant-create', \App\Classroom::class)
        <li>
            <a href="{{ route('tenant.classrooms.create', $branchOffice) }}">
                <span class="title">Crear aula</span>
            </a>
        </li>
        @endcan
    </ul>
</li>


<li class="has-sub">
    <a href="#">
        <i class="fa fa-puzzle-piece"></i>
        <span class="title">Cursos</span>
    </a>
    <ul>
        @can('tenant-view', \App\Course::class)
        <li>
            <a href="{{ route('tenant.courses.index', $branchOffice) }}">
                <span class="title">Todas los cursos</span>
            </a>
        </li>
        @endcan

        @can('tenant-create', \App\Course::class)
        <li>
            <a href="{{ route('tenant.courses.create', $branchOffice) }}">
                <span class="title">Crear cursos</span>
            </a>
        </li>
        @endcan
    </ul>
</li>

<li class="has-sub">
    <a href="#">
        <i class="fas fa-th-large"></i>
        <span class="title">Tipo de curso</span>
    </a>
    <ul>
        @can('tenant-view', \App\TypeCourse::class)
        <li>
            <a href="{{ route('tenant.typeCourses.index', $branchOffice) }}">
                <span class="title">Todos los tipos de curso</span>
            </a>
        </li>
        @endcan

        @can('tenant-create', \App\TypeCourse::class)
        <li>
            <a href="{{ route('tenant.typeCourses.create', $branchOffice) }}">
                <span class="title">Crear tipo de curso</span>
            </a>
        </li>
        @endcan
    </ul>
</li>

<li class="has-sub">
    <a href="#">
        <i class="fa fa-sign"></i>
        <span class="title">Recursos</span>
    </a>
    <ul>
        @can('tenant-view', \App\Resource::class)
        <li>
            <a href="{{ route('tenant.resources.index', $branchOffice) }}">
                <span class="title">Todos los recursos</span>
            </a>
        </li>
        @endcan

        @can('tenant-create', \App\Resource::class)
        <li>

            <a href="{{ route('tenant.resources.create', $branchOffice) }}">
                <span class="title">Crear recurso</span>
            </a>
        </li>
        @endcan
    </ul>
</li>

<li class="has-sub">
    <a href="#">
        <i class="fa fa-chalkboard-teacher"></i>
        <span class="title">Profesores</span>
    </a>
    <ul>
        @can('tenant-view', \App\Teacher::class)
        <li>
            <a href="{{ route('tenant.teachers.index', $branchOffice) }}">
                <span class="title">Todos los profesores</span>
            </a>
        </li>
        @endcan

        @can('tenant-create', \App\Teacher::class)
        <li>
            <a href="{{ route('tenant.teachers.create', $branchOffice) }}">
                <span class="title">Crear profesor</span>
            </a>
        </li>
        @endcan
    </ul>
</li>


<li class="has-sub">
    <a href="#">
        <i class="fa fa-calendar-alt"></i>
        <span class="title">Promociones</span>
    </a>
    <ul>
        @can('tenant-view', \App\Promotion::class)
           <li>
               <a href="{{ route('tenant.promotions.index', $branchOffice) }}">
                   <span class="title">Todas las promociones</span>
               </a>
           </li>
        @endcan

        @can('tenant-create', \App\Promotion::class)
            <li>
                <a href="{{ route('tenant.promotions.create', $branchOffice) }}">
                    <span class="title">Crear promocion</span>
                </a>
            </li>
        @endcan
    </ul>
</li>
