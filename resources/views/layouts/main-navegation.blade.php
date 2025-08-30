<!-- Main navigation -->
				<div class="sidebar-section">
					<ul class="nav nav-sidebar" data-nav-type="accordion">

						<!-- Main -->
						<li class="nav-item-header pt-0">
							<div class="text-uppercase fs-sm lh-sm opacity-50 sidebar-resize-hide">Principal</div>
							<i class="ph-dots-three sidebar-resize-show"></i>
						</li>
						<li class="nav-item">
							<a href="{{ route('welcome') }}" class="nav-link {{ Route::is('welcome') ? 'active' : '' }}">
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
						
						{{-- <li class="nav-item">
							<a href="../../../../docs/other_changelog.html" class="nav-link">
								<i class="ph-list-numbers"></i>
								<span>Changelog</span>
								<span class="badge bg-primary align-self-center rounded-pill ms-auto">4.0</span>
							</a>
						</li>

						
						<li class="nav-item-header">
							<div class="text-uppercase fs-sm lh-sm opacity-50 sidebar-resize-hide">Forms</div>
							<i class="ph-dots-three sidebar-resize-show"></i>
						</li>
						<li class="nav-item nav-item-submenu">
							<a href="#" class="nav-link">
								<i class="ph-note-pencil"></i>
								<span>Form components</span>
							</a>
							<ul class="nav-group-sub collapse">
								<li class="nav-item"><a href="form_autocomplete.html" class="nav-link">Autocomplete</a></li>
								<li class="nav-item"><a href="form_checkboxes_radios.html" class="nav-link">Checkboxes &amp; radios</a></li>
							</ul>
						</li> --}}
						
						
						<!-- /page kits -->

					</ul>
				</div>
				<!-- /main navigation -->