<div class="sidebar-menu">
	<div class="sidebar-menu-inner">
		<header class="logo-env">
			<!-- logo -->
			<div class="logo">
				<a href="{{ route('home') }}">
					<img src="{{ asset('admin/images/logo@2x.png') }}" width="120" alt=""/>
				</a>
			</div>

			<!-- logo collapse icon -->
			<div class="sidebar-collapse">
				<a href="#" class="sidebar-collapse-icon with-animation">
					<i class="entypo-menu"></i>
				</a>
			</div>

			<div class="sidebar-mobile-menu visible-xs">
				<a href="#" class="with-animation">
					<i class="entypo-menu"></i>
				</a>
			</div>
		</header>
		
		<div class="sidebar-user-info">
			<div class="sui-normal">
				<a class="user-link">
					<img src="{{ asset('admin/images/thumb-1@2x.png') }}" width="55" alt="" class="img-circle"/>

					<span>¡Hola de nuevo,</span>
					<strong>{{ Auth()->user()->name }}!</strong>
				</a>
			</div>
		</div>
								
		<ul id="main-menu" class="main-menu">
			<li class="opened active opened active">
				<a href="{{ route('home') }}">
					<i class="entypo-gauge"></i>
					<span class="title">Dashboard</span>
				</a>
			</li>

			<li class="has-sub">
				<a href="#">
					<i class="entypo-layout"></i>
					<span class="title">Registrar</span>
				</a>
				<ul>
					<li>
						<a href="#">
							<span class="title">Estudiante</span>
						</a>
					</li>

					<li>
						<a href="#">
							<span class="title">Profesor</span>
						</a>
					</li>
					
					<li>
						<a href="#">
							<span class="title">Promoción</span>
						</a>
					</li>
					
					<li>
						<a href="#">
							<span class="title">Curso</span>
						</a>
					</li>
					
					<li>
						<a href="#">
							<span class="title">Aula</span>
						</a>
					</li>
				</ul>
			</li>

			<li>
				<a href="index.html" target="_blank">
					<i class="entypo-pencil"></i>
					<span class="title">Inscripción</span>
				</a>
			</li>

			<li>
				<a href="index.html" target="_blank">
					<i class="entypo-window"></i>
					<span class="title">Gestionar Cursos</span>
				</a>
			</li>

			<li>
				<a href="index.html" target="_blank">
					<i class="entypo-home"></i>
					<span class="title">Gestionar Aulas</span>
				</a>
			</li>
		</ul>
	</div>
</div>