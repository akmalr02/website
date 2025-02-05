
	<section class="section-intro">

		<div class="content-intro p-t-77 p-b-50" style="background-color: #FAFAF9;">
			<div class="container">
				<div class="title-section-ourmenu t-center m-b-22">
					<h5 class="romadan-berita m-t-2">
						Berita Terkini
					</h5>
				</div>
				<div class="row">
					@forelse ($berita_terkini as $item)
						<div class="col-md-4 p-t-33">
						<!-- Block1 -->
						<div class="">
							<div class="pic-blo4 hov-img-zoom bo-rad-10 pos-relative">
								<a href="{{route('berita-fe', $item->slug)}}">
									<img src="{{asset('storage/romadan_gambar_web/'.$item->image)}}" alt="IMG-BLOG" height="220px">
								</a>
							</div>
							

							<div class="text-blo4 p-t-33">
								<div class="txt32 flex-w p-b-24">
									<span>
										{{date('d F, Y', strtotime($item->created_at))}}
										<span class="m-r-6 m-l-4">|</span>
									</span>

									<span>
										{{$item->nama_kategori}}
										<span class="m-r-6 m-l-4"></span>
									</span>
								</div>
								<div>
									<a href="{{route('berita-fe', $item->slug)}}" class="berita-terkini-judul-romadan">{{$item->judul}}</a>
								</div>
							</div>
						</div>

						
						
					</div>
					
					@empty
							<div class="container">                         
						<h5 class="romadan-faq m-t-2">
							Berita Terkini Kosong !
						</h5>
							  </div>
						
					@endforelse
					<div class="col-md-12 p-t-20 romadan-berita-button-home">
						<a href="{{route('tentang-fe')}}" class="btn-tentang-romadan flex-c-m size1 txt3-romadan trans-0-4 mt-3">
								Lihat Selengkapnya<i class="ml-3 fa fa-arrow-right"
								aria-hidden="true"></i>
							</a>
					</div>
					

				</div>
			</div>
		</div>
	</section>