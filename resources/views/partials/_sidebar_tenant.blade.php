<aside class="main-sidebar">
    <section class="sidebar">
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header text-center">PANEL DE NAVEGACIÓN</li>

            @can('tenant-view', \App\BranchOffice::class)
            <li><a href="{{ route('tenant.dashboard', $branchOffice) }}"><i class="fa fa-dashboard"></i><span>Dashboard</span></a></li>
            @endcan

            @if(auth()->user()->can('tenant-view', \App\Promotion::class) || auth()->user()->can('tenant-create', \App\Promotion::class))
                <li class="treeview">
                    <a href="#"><i class="fa fa-book"></i> <span>Promociones</span><span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span></a>
                    <ul class="treeview-menu">
                        @can('tenant-create', \App\Promotion::class)
                            <li><a href="{{ route('tenant.promotions.create', $branchOffice) }}"><i class="fa fa-circle-o"></i> Crear promoción</a></li>
                        @endcan

                        @can('tenant-view', \App\Promotion::class)
                            <li><a href="{{ route('tenant.promotions.index', $branchOffice) }}"><i class="fa fa-circle-o"></i> Todas las promociones</a></li>
                        @endcan
                    </ul>
                </li>
            @endif

            @if(auth()->user()->can('tenant-view', \App\Course::class) || auth()->user()->can('tenant-create', \App\Course::class) ||  auth()->user()->can('tenant-view', \App\TypeCourse::class) || auth()->user()->can('tenant-create', \App\TypeCourse::class))
                <li class="treeview">
                    <a href="#"><i class="fa fa-laptop"></i> <span>Cursos</span><span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span></a>
                    <ul class="treeview-menu">
                        @can('tenant-create', \App\Course::class)
                            <li><a href="{{ route('tenant.courses.create', $branchOffice) }}"><i class="fa fa-circle-o"></i> Crear curso</a></li>
                        @endcan
                        @can('tenant-view', \App\Course::class)
                            <li><a href="{{ route('tenant.courses.index', $branchOffice) }}"><i class="fa fa-circle-o"></i> Todos los cursos</a></li>
                        @endcan
                        <li class="treeview">
                            <a href="#"><i class="fa fa-circle-o"></i> Tipo de cursos<span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span></a>
                            <ul class="treeview-menu">
                                @can('tenant-create', \App\TypeCourse::class)
                                    <li><a href="{{ route('tenant.typeCourses.create', $branchOffice) }}"><i class="fa fa-circle-o"></i> Crear tipo de curso</a></li>
                                @endcan

                                @can('tenant-view', \App\TypeCourse::class)
                                    <li><a href="{{ route('tenant.typeCourses.index', $branchOffice) }}"><i class="fa fa-circle-o"></i> Todos los tipos de cursos</a></li>
                                @endcan
                            </ul>
                        </li>
                    </ul>
                </li>
            @endif

            @if( auth()->user()->can('tenant-view', \App\Schedule::class) || auth()->user()->can('tenant-create', \App\Schedule::class) )
                <li class="treeview">
                    <a href="#"><i class="fa fa-calendar-o"></i> <span>Horario</span><span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span></a>
                    <ul class="treeview-menu">
                        @can('tenant-create', \App\Schedule::class)
                            <li><a href="{{ route('tenant.schedules.create', $branchOffice) }}"><i class="fa fa-circle-o"></i> Crear horario</a></li>
                        @endcan

                        @can('tenant-view', \App\Schedule::class)
                            <li><a href="{{ route('tenant.schedules.index', $branchOffice) }}"><i class="fa fa-circle-o"></i> Todos los horarios</a></li>
                        @endcan
                    </ul>
                </li>
            @endif

            @if( auth()->user()->can('tenant-view', \App\Classroom::class) || auth()->user()->can('tenant-create', \App\Classroom::class) )
            <li class="treeview">
                <a href="#"><i class="fa fa-building-o" aria-hidden="true"></i> <span>Aulas</span><span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span></a>
                <ul class="treeview-menu">
                    @can('tenant-create', \App\Classroom::class)
                        <li><a href="{{ route('tenant.classrooms.create', $branchOffice) }}"><i class="fa fa-circle-o"></i> Crear aula</a></li>
                    @endcan

                    @can('tenant-view', \App\Classroom::class)
                        <li><a href="{{ route('tenant.classrooms.index', $branchOffice) }}"><i class="fa fa-circle-o"></i> Todas las aulas</a></li>
                    @endcan
                </ul>
            </li>
            @endif

            @if( auth()->user()->can('tenant-view', \App\Resource::class) || auth()->user()->can('tenant-create', \App\Resource::class) )
            <li class="treeview">
                <a href="#"><i class="fa fa-usd" aria-hidden="true"></i> <span>Recursos</span><span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span></a>
                <ul class="treeview-menu">
                    @can('tenant-create', \App\Resource::class)
                        <li><a href="{{ route('tenant.resources.create', $branchOffice) }}"><i class="fa fa-circle-o"></i> Crear recurso</a></li>
                    @endcan

                    @can('tenant-view', \App\Resource::class)
                        <li><a href="{{ route('tenant.resources.index', $branchOffice) }}"><i class="fa fa-circle-o"></i> Todos los recursos</a></li>
                    @endcan
                </ul>
            </li>
            @endif

            @if( auth()->user()->can('tenant-view', \App\Teacher::class) || auth()->user()->can('tenant-create', \App\Teacher::class) )
            <li class="treeview">
                <a href="#"><i class="fa fa-user" aria-hidden="true"></i> <span>Profesores</span><span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span></a>
                <ul class="treeview-menu">
                    @can('tenant-create', \App\Teacher::class)
                        <li><a href="{{ route('tenant.teachers.create', $branchOffice) }}"><i class="fa fa-circle-o"></i> Crear profesor</a></li>
                    @endcan

                    @can('tenant-view', \App\Teacher::class)
                        <li><a href="{{ route('tenant.teachers.index', $branchOffice) }}"><i class="fa fa-circle-o"></i> Todos los profesores</a></li>
                    @endcan
                </ul>
            </li>
            @endif

            @if( auth()->user()->can('tenant-view', \App\Student::class) || auth()->user()->can('tenant-create', \App\Student::class) )
            <li class="treeview">
                <a href="#"><i class="fa fa-graduation-cap"></i> <span>Estudiantes</span><span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span></a>
                <ul class="treeview-menu">
                    @can('tenant-create', \App\Student::class)
                        <li><a href="{{ route('tenant.students.create', $branchOffice) }}"><i class="fa fa-circle-o"></i> Crear estudiante</a></li>
                    @endcan

                    @can('tenant-view', \App\Student::class)
                        <li><a href="{{ route('tenant.students.index', $branchOffice) }}"><i class="fa fa-circle-o"></i> Todos los estudiantes</a></li>
                    @endcan
                </ul>
            </li>
            @endif

            @if(  auth()->user()->can('tenant-view', \App\Invoice::class) )
                <li><a href="{{ route('tenant.invoice.index', $branchOffice) }}"><i class="fa fa-file-o"></i><span> Todas las facturas</span></a></li>
            @endif

            @if(  auth()->user()->can('tenant-update', \App\Invoice::class) )
                <li><a href="{{ route('tenant.accounts_receivable.index', $branchOffice) }}"><i class="fa fa-money"></i> <span>Cuentas x Cobrar</span></a></li>
            @endif


            <li class="header">Accesos rapido</li>
            {{  new App\Http\ViewComponents\TenantQuickAccessBtn($branchOffice) }}
        </ul>
    </section>
</aside>