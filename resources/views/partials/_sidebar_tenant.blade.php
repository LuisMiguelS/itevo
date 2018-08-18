<aside class="main-sidebar">
    <section class="sidebar">
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header text-center">PANEL DE NAVEGACIÓN</li>
            @can('tenant-view', \App\BranchOffice::class)
            <li>
                <a href="{{ route('tenant.dashboard', $branchOffice) }}">
                    <i class="fa fa-dashboard"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            @endcan

            <li class="treeview">
                <a href="#">
                    <i class="fa fa-book"></i> <span>Aulas</span>
                    <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                </a>
                <ul class="treeview-menu">
                    @can('tenant-view', \App\Classroom::class)
                        <li>
                            <a href="{{ route('tenant.classrooms.index', $branchOffice) }}">
                                <i class="fa fa-circle-o"></i> Todas las aulas
                            </a>
                        </li>
                    @endcan

                    @can('tenant-create', \App\Classroom::class)
                        <li>
                            <a href="{{ route('tenant.classrooms.create', $branchOffice) }}">
                                <i class="fa fa-circle-o"></i> Crear aula
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>

            <li class="treeview">
                <a href="#">
                    <i class="fa fa-book"></i> <span>Cursos</span>
                    <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                </a>
                <ul class="treeview-menu">
                    @can('tenant-view', \App\Course::class)
                        <li>
                            <a href="{{ route('tenant.courses.index', $branchOffice) }}">
                                <i class="fa fa-circle-o"></i> Todos los cursos
                            </a>
                        </li>
                    @endcan

                    @can('tenant-create', \App\Course::class)
                        <li>
                            <a href="{{ route('tenant.courses.create', $branchOffice) }}">
                                <i class="fa fa-circle-o"></i> Crear curso
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>

            <li class="treeview">
                <a href="#">
                    <i class="fa fa-book"></i> <span>Tipos de cursos</span>
                    <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                </a>
                <ul class="treeview-menu">
                    @can('tenant-view', \App\TypeCourse::class)
                        <li>
                            <a href="{{ route('tenant.typeCourses.index', $branchOffice) }}">
                                <i class="fa fa-circle-o"></i> Todos los tipos de cursos
                            </a>
                        </li>
                    @endcan

                    @can('tenant-create', \App\TypeCourse::class)
                        <li>
                            <a href="{{ route('tenant.typeCourses.create', $branchOffice) }}">
                                <i class="fa fa-circle-o"></i> Crear tipo de curso
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>

            <li class="treeview">
                <a href="#">
                    <i class="fa fa-book"></i> <span>Recursos</span>
                    <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                </a>
                <ul class="treeview-menu">
                    @can('tenant-view', \App\Resource::class)
                        <li>
                            <a href="{{ route('tenant.resources.index', $branchOffice) }}">
                                <i class="fa fa-circle-o"></i> Todos los recursos
                            </a>
                        </li>
                    @endcan

                    @can('tenant-create', \App\Resource::class)
                        <li>
                            <a href="{{ route('tenant.resources.create', $branchOffice) }}">
                                <i class="fa fa-circle-o"></i> Crear recurso
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>

            <li class="treeview">
                <a href="#">
                    <i class="fa fa-book"></i> <span>Promociones</span>
                    <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                </a>
                <ul class="treeview-menu">
                    @can('tenant-view', \App\Promotion::class)
                        <li>
                            <a href="{{ route('tenant.promotions.index', $branchOffice) }}">
                                <i class="fa fa-circle-o"></i> Todas las promociones
                            </a>
                        </li>
                    @endcan

                    @can('tenant-create', \App\Promotion::class)
                        <li>
                            <a href="{{ route('tenant.promotions.create', $branchOffice) }}">
                                <i class="fa fa-circle-o"></i> Crear promoción
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>

            <li class="treeview">
                <a href="#">
                    <i class="fa fa-book"></i> <span>Profesores</span>
                    <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                </a>
                <ul class="treeview-menu">
                    @can('tenant-view', \App\Teacher::class)
                        <li>
                            <a href="{{ route('tenant.teachers.index', $branchOffice) }}">
                                <i class="fa fa-circle-o"></i> Todos los profesores
                            </a>
                        </li>
                    @endcan

                    @can('tenant-create', \App\Teacher::class)
                        <li>
                            <a href="{{ route('tenant.teachers.create', $branchOffice) }}">
                                <i class="fa fa-circle-o"></i> Crear profesor
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>

            <li class="treeview">
                <a href="#">
                    <i class="fa fa-book"></i> <span>Estudiantes</span>
                    <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                </a>
                <ul class="treeview-menu">
                    @can('tenant-view', \App\Student::class)
                        <li>
                            <a href="{{ route('tenant.students.index', $branchOffice) }}">
                                <i class="fa fa-circle-o"></i> Todos los estudiantes
                            </a>
                        </li>
                    @endcan

                    @can('tenant-create', \App\Student::class)
                        <li>
                            <a href="{{ route('tenant.students.create', $branchOffice) }}">
                                <i class="fa fa-circle-o"></i> Crear estudiante
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>

            <li class="header">LABELS</li>
            @if($branchOffice->currentPromotion()->currentPeriod())
            <li>
                <a href="{{ route('tenant.periods.course-period.index', ['branchOffice' => $branchOffice, 'period' => $branchOffice->currentPromotion()->currentPeriod()]) }}">
                    <i class="fa fa-circle-o text-red"></i> <span>Cursos activos</span>
                </a>
            </li>
            @endif
            <li><a href="#"><i class="fa fa-circle-o text-yellow"></i> <span>Warning</span></a></li>
            <li><a href="#"><i class="fa fa-circle-o text-aqua"></i> <span>Information</span></a></li>
        </ul>
    </section>
</aside>