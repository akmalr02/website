@extends('layouts.webromadan_backend.master_layout')

@section('css')
@endsection


@section('script_atas')
<script src="{{asset('webromadan/be/js/jquery/jquery.min.js')}}"></script>
<script src="{{asset('webromadan/be/js/vendor/forms/validation/validate.min.js')}}"></script>
<script src="{{asset('webromadan/be/js/vendor/forms/selects/select2.min.js')}}"></script>
@endsection

@section('script_bawah')
<script src="{{asset('webromadan/be/demo/pages/form_validation_library.js')}}"></script>

<script src="{{asset('webromadan/be/demo/pages/form_select2.js')}}"></script>
{{-- <script>

		$(function(){
			$.ajaxSetup({
				headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
			});
		});


		$(function(){


			$('#role').on('change',function(){

				let roleall = $('#role').val();


				$.ajax({
					type: 'POST',
					url: "{{route('SatkerRole')}}",
					data : {roleall: roleall},
					cache: false,

					success: function(msg){
						$('#satker').html(msg);

					},
					error: function(data){
						console.log('error:',data)
					}
				})
			})
			


		});

</script> --}}
@endsection

@section('content')

<!-- Form validation -->
					<div class="card">
						<div class="card-header">
							<h5 class="mb-0">Tambah User WEBSITE ROMADAN</h5>
                            @include('layouts.webromadan_backend.session_notif')
						</div>

						<form class="form-validate-jquery" action="{{route('users.store')}}" autocomplete="off" method="POST">
                            @csrf
							<div class="card-body">

                                <div class="mb-4">

									<!-- Username Input -->
									{{-- <div class="row mb-3">
										<label class="col-form-label col-lg-3">Username <span class="text-danger">*</span></label>
										<div class="col-lg-9">
											<input type="text" name="username" class="form-control" required placeholder="Username">
										</div>
									</div> --}}
									<!-- /Username Input -->

                                    <!-- NIP INPUT -->
									{{-- <div class="row mb-3">
										<label class="col-form-label col-lg-3">NIP <span class="text-danger">*</span></label>
										<div class="col-lg-9">
											<input type="text" name="nip" class="form-control" required placeholder="NIP">
										</div>
									</div> --}}
									<!-- /NIP INPUT -->

                                    <!-- NAMA INPUT -->
									<div class="row mb-3">
										<label class="col-form-label col-lg-3">Nama <span class="text-danger">*</span></label>
										<div class="col-lg-9">
											<input type="text" name="name" class="form-control" required placeholder="Nama">
										</div>
									</div>
									<!-- /NAMA INPUT -->

                                    <!-- EMAIL INPUT -->
									<div class="row mb-3">
										<label class="col-form-label col-lg-3">Email <span class="text-danger">*</span></label>
										<div class="col-lg-9">
											<input type="email" name="email" class="form-control" required placeholder="Email">
										</div>
									</div>
									<!-- /EMAIL INPUT -->

									<!-- /ROLE INPUT -->
									<div class="row mb-3">
										<label class="col-form-label col-lg-3">Role <span class="text-danger">*</span></label>
										<div class="col-lg-9">
											<select id="role" value="{{ old('role') }}" name="role" class="form-control form-control-select2 select" @error('role') is-invalid @enderror required>
												<option>--Pilih Role--</option>
												
												@foreach ($data['role'] as $item)
												<option value="{{ $item->id }}" {{ old('role') == $item->id ? 'selected' : null}}>{{$loop->iteration." - ".$item->name}}</option>
												@endforeach
												

											</select>

											<!-- error message untuk judul -->
											@error('kategori')
											<div class="alert alert-danger mt-2">
												{{ $message }}
											</div>
											@enderror
										</div>
									</div>
									{{-- /ROLE INPUT --}}

                                    <!-- PASSWORD INPUT -->
									<div class="row mb-3">
										<label class="col-form-label col-lg-3">Password <span class="text-danger">*</span></label>
										<div class="col-lg-9">
											<input type="password" name="password" class="form-control" required placeholder="Password">
										</div>
									</div>
									<!-- /PASSWORD INPUT -->

                                    <!-- PASSWORD CONFIRM INPUT -->
									<div class="row mb-3">
										<label class="col-form-label col-lg-3">Konfirmasi Password <span class="text-danger">*</span></label>
										<div class="col-lg-9">
											<input type="password" name="password_confirmation" class="form-control" required placeholder="Password Konfirmasi">
										</div>
									</div>
									<!-- /PASSWORD CONFIRM INPUT -->

								</div>
						</div>

						<div class="card-footer d-flex justify-content-end">
							<a href="{{route('users.index') }}" class="btn btn-warning"><i class="ph-caret-double-left"></i>Kembali</a>
							<button type="reset" class="btn btn-light ms-3" id="reset">Reset</button>
							<button type="submit" class="btn btn-primary ms-3">Submit <i class="ph-paper-plane-tilt ms-2"></i></button>
						</div>
							</form>
					</div>
					<!-- /form validation -->

@endsection
