@extends('layouts.app')

@section('content')
<div class="row">
	@php
		$manage_password = true;
	@endphp
	@include('auth.nav')
	<div class="col-md-9">
		<div class="row">
			<div class="col-md-12">
				<form class="card input-form" action="{{route('update_password')}}" method="POST">
					
					@csrf
					<div class="card-body">
						@if(session()->has('success'))
						<div class="alert alert-success alert-dismissible">
							<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
							{{ session()->get('success') }}
						</div>
						@endif
						<div class="col-md-6">
							<label class="f-12">Old Password</label>
							<input class="form-control @error('oldpassword') is-invalid @enderror" type="password" value="" required name="oldpassword">
							@error('oldpassword')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
						</div>
						<div class="col-md-6">
							<label class="f-12">New Password</label>
							<input class="form-control @error('password') is-invalid @enderror" type="password" value="" autocomplete="new-password" required name="password">
							@error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
						</div>
						<div class="col-md-6">
							<label class="f-12">Confirm Password</label>
							<input class="form-control @error('confirmpassword') is-invalid @enderror" type="password" value="" autocomplete="new-password" required name="confirmpassword">
							@error('confirmpassword')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
						</div>
					</div>
					<div class="card-footer text-right card-header-white">
						<button class="btn btn-gold">Save</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
@endsection


@section('js')
<script type="text/javascript" src="{{asset('custom/js/account.js?'.time())}}"></script>
@endsection