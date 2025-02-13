	<header>
		<!-- Header desktop -->
		<div class="wrap-menu-header gradient1 trans-0-10">
			<div class="container h-full">
				<div class="wrap_header trans-0-3">
					<!-- Logo -->
					<div class="logo">
						<a href="{{route('homefe')}}">
							<img src="{{asset('frontend_romadan_web/images/icons/romadan/logo_4.png')}}" alt="ROMADAN-LOGO" data-logofixed="{{asset('frontend_romadan_web/images/icons/romadan/logo_3.png')}}">
						</a>
					</div>

					<!-- Menu -->
					<div class="wrap_menu p-l-200 p-l-0-xl">
						<nav class="menu">
							<ul class="main_menu">
								<li class="dropdown">
									<a href="#" class="" data-toggle="dropdown">Profile </span></a>
									<ul class="dropdown-menu p-l-20 p-l-0-xl mt-4 dropdown-menu-romadan">
									{{-- MENU PROFILE --}}
									<li><a href="{{route('visi-misi-fe')}}">Visi Misi</a></li>
									<li><a href="{{route('sejarah-fe')}}">Sejarah</a></li>
									<li><a href="{{route('organisasi-fe')}}">Organisasi</a></li>
									<li><a href="{{route('tentang-fe')}}">Tentang</a></li>
									{{-- END MENU PROFILE --}}
									</ul>
								</li>
								<li>
									<a href="{{route('layanan-fe')}}">Layanan</a>
								</li>
								{{-- <li>
									<a href="{{route('kegiatan-index-fe')}}">Kegiatan</a>
								</li> --}}
								{{-- <li class="dropdown">
									<a href="#" class="" data-toggle="dropdown">Kegiatan BelumFIX</span></a>
									<ul class="dropdown-menu p-l-20 p-l-0-xl mt-4 dropdown-menu-romadan">
									<li><a href="#">Kegiatan 1</a></li>
									<li class="dropdown-submenu-romadan">
									<a href="#">Kegiatan 2 </a>
									<ul class="dropdown-menu p-l-20 p-l-0-xl">
										<li><a href="#">Sub-kegiatan 2.1</a></li>
										<li><a href="#">Sub-kegiatan 2.2</a></li>
										<li class="dropdown-submenu-romadan">
										<a href="#">Sub-kegiatan 2.3 </a>
										<ul class="dropdown-menu p-l-20 p-l-0-xl">
											<li><a href="#">Sub-sub-kegiatan 2.3.1</a></li>
											<li><a href="#">Sub-sub-kegiatan 2.3.2</a></li>
										</ul>
										</li>
									</ul>
									</li>
									<li><a href="#">Kegiatan 3</a></li>
									</ul>
								</li> --}}
								<li>
									<a href="{{route('informasi-publik-index-fe')}}">Informasi Publik</a>
								</li>
								<li>
									<a href="{{route('publikasi-index-fe')}}">Publikasi</a>
								</li>
								<li>
									<a href="{{route('faq-index-fe')}}">FAQ</a>
								</li>
								{{-- <li>
									<a href="menu.html">Search</a>
								</li> --}}
							</ul>
							
						</nav>
					</div>

					<!-- Social -->
					<div class="social flex-w flex-l-m p-r-10">
						
						{{-- <button class="btn-show-sidebar romadan-menu-mobile m-l-33 trans-0-4"></button> --}}
						<i class="btn-show-sidebar romadan-menu-mobile m-r-20 fa-solid fa-bars fa-2xl" style="color: white"></i>
					</div>
					
				</div>
			</div>
		</div>
	</header>