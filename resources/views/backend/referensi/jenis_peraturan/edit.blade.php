@extends('layouts.webromadan_backend.master_layout')

@section('css')
<script src="{{asset('webromadan/be/js/jquery/jquery.min.js')}}"></script>
<script src="{{asset('webromadan/be/js/vendor/tables/datatables/datatables.min.js')}}"></script>
@endsection


@section('script_atas')
<script src="{{asset('webromadan/be/js/jquery/jquery.min.js')}}"></script>
<script src="{{asset('webromadan/be/js/vendor/forms/validation/validate.min.js')}}"></script>
<script src="{{asset('webromadan/be/js/vendor/forms/selects/select2.min.js')}}"></script>
<script src="{{asset('webromadan/be/js/vendor/editors/ckeditor/ckeditor_classic.js')}}"></script>
@endsection

@section('script_bawah')
<script src="{{asset('webromadan/be/demo/pages/form_validation_library.js')}}"></script>
<script src="{{asset('webromadan/be/demo/pages/form_select2.js')}}"></script>
<script src="{{asset('webromadan/be/demo/pages/editor_ckeditor_classic.js')}}"></script>
@endsection

@section('content')

<!-- Form validation -->
					<div class="card">
						<div class="card-header">
							<h5 class="mb-0">Edit Nama Jenis Peraturan</h5>
						</div>

						<form class="form-validate-jquery" action="{{route('jenis-peraturan.update', encrypt($peraturan->id_jenis_peraturan))}}" method="post" autocomplete="off">
							@csrf
                            @method('PUT')
							<div class="card-body">
							
								<div class="mb-4">

									<!-- Nama Kategori -->
									<div class="row mb-3">
										<label class="col-form-label col-lg-2">Nama Jenis Peraturan <span class="text-danger">*</span></label>
										<div class="col-lg-10">
											<input value="{{ old('nama_jenis_peraturan') ?? $peraturan->nama_jenis_peraturan }}" type="text" name="nama_jenis_peraturan" class="form-control @error('nama_jenis_peraturan') is-invalid @enderror" required placeholder="Masukkan Nama Kategori">
											<!-- error message untuk nama_jenis_peraturan -->
											@error('nama_jenis_peraturan')
											<div class="alert alert-danger mt-2">
												{{ $message }}
											</div>
											@enderror
										</div>
									</div>
									<!-- /Nama Kategori -->

								</div>

						</div>

						<div class="card-footer d-flex justify-content-end">
							 <a href="{{route('jenis-peraturan.index') }}" class="btn btn-warning"><i class="ph-caret-double-left"></i>Batal</a>
							 <button type="reset" class="btn btn-light ms-3" id="reset">Reset</button>
							<button type="submit" class="btn btn-primary ms-3">Update <i class="ph-paper-plane-tilt ms-2"></i></button>
						</div>
							</form>
					</div>
<!-- /form validation -->
@endsection




