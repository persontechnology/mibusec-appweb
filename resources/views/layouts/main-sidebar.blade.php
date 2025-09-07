<div class="sidebar sidebar-dark sidebar-main sidebar-expand-lg">

			<!-- Sidebar content -->
			<div class="sidebar-content">

				<!-- Sidebar header -->
				<div class="sidebar-section">
					<div class="sidebar-section-body d-flex justify-content-center">
						<h5 class="sidebar-resize-hide flex-grow-1 my-auto">Navegación</h5>

						<div>
							<button type="button" class="btn btn-flat-white btn-icon btn-sm rounded-pill border-transparent sidebar-control sidebar-main-resize d-none d-lg-inline-flex">
								<i class="ph-arrows-left-right"></i>
							</button>

							<button type="button" class="btn btn-flat-white btn-icon btn-sm rounded-pill border-transparent sidebar-mobile-main-toggle d-lg-none">
								<i class="ph-x"></i>
							</button>
						</div>
					</div>
				</div>
				<!-- /sidebar header -->

				<!-- Main navigation -->
				<div class="sidebar-section">
					<ul class="nav nav-sidebar" data-nav-type="accordion">

						<!-- Main -->
						
						<li class="nav-item-header pt-0">
							<div class="text-uppercase fs-sm lh-sm opacity-50 sidebar-resize-hide">Main</div>
							<i class="ph-dots-three sidebar-resize-show"></i>
						</li>
						
						<li class="nav-item">
							<a href="{{ route('dashboard') }}" class="nav-link {{ Route::is('dashboard') ? 'active' : '' }}">
								<i class="ph-house"></i>
								<span>Inicio</span>
							</a>
						</li>
						<li class="nav-item">
							<a href="{{ route('stops.index') }}" class="nav-link {{ Route::is('stops.*') ? 'active' : '' }}">
								<i class="ph ph-traffic-signal"></i>
								<span>Paradas</span>
							</a>
						</li>
						
						<li class="nav-item">
							<a href="{{ route('vehicles.index') }}" class="nav-link {{ Route::is('vehicles.*') ? 'active' : '' }}">
								<i class="ph ph-bus"></i>
								<span>Vehiculos</span>
							</a>
						</li>
						<li class="nav-item">
							
							<a href="{{ route('routes.index') }}" class="nav-link {{ Route::is('routes.*') || Route::is('route.stops.*') ? 'active' : '' }}">
								<i class="ph ph-path"></i>
								<span>Rutas</span>
							</a>
						</li>

						<li class="nav-item-header pt-0">
							<div class="text-uppercase fs-sm lh-sm opacity-50 sidebar-resize-hide">Sistema</div>
							<i class="ph-dots-three sidebar-resize-show"></i>
						</li>
						
						<li class="nav-item">
							<a href="{{ route('rol-permisos.index') }}" class="nav-link {{ Route::is('rol-permisos.*')?'active':'' }}">
								<i class="fa-solid fa-sliders"></i>
								<span>
									Roles y permisos
								</span>
							</a>
						</li>
						
						<!-- Forms -->
						{{-- <li class="nav-item-header">
							<div class="text-uppercase fs-sm lh-sm opacity-50 sidebar-resize-hide">Forms</div>
							<i class="ph-dots-three sidebar-resize-show"></i>
						</li>
						<li class="nav-item nav-item-submenu nav-item-expanded nav-item-open">
							<a href="#" class="nav-link">
								<i class="ph-note-pencil"></i>
								<span>Form components</span>
							</a>
							<ul class="nav-group-sub collapse show">
								
								<li class="nav-item"><a href="form_controls_extended.html" class="nav-link">Extended controls</a></li>
								<li class="nav-item"><a href="form_floating_labels.html" class="nav-link active">Floating labels</a></li>
								<li class="nav-item"><a href="form_actions.html" class="nav-link">Form actions</a></li>
								
							</ul>
						</li> --}}
					
						
						<!-- /forms -->

						

					</ul>
				</div>
				<!-- /main navigation -->
			</div>
			<!-- /sidebar content -->
			
		</div>