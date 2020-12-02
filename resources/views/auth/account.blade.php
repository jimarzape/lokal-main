@extends('layouts.app')

@section('content')
<div class="row">
	@php
		$profile = true;
	@endphp
	@include('auth.nav')
	<div class="col-md-9">
		<div class="row">
			<div class="col-md-12">
				<div class="card info-display">
					<div class="card-header text-right card-header-white">
						<a href="#" class="no-decoration show-form">Edit</a>
					</div>
					<div class="card-body">
						@if(session()->has('success'))
						<div class="alert alert-success alert-dismissible">
							<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
							{{ session()->get('success') }}
						</div>
						@endif
						<div class="col-md-4">
							<label class="f-12">Name</label>
							<p>{{$user->userFullName}}</p>
						</div>
						<div class="col-md-4">
							<label class="f-12">Mobile Number</label>
							<p>{{$user->userMobile}}</p>
						</div>
						<div class="col-md-4">
							<label class="f-12">Email</label>
							<p>{{$user->userEmail}}</p>
						</div>
					</div>
				</div>
				<form class="card input-form hide" action="{{route('update_info')}}" method="POST">
					@csrf
					<div class="card-header text-right card-header-white">
						<a href="#" class="no-decoration hide-form">Cancel</a>
					</div>
					<div class="card-body">
						<div class="col-md-6">
							<label class="f-12">Name</label>
							<input class="form-control @error('name') is-invalid @enderror" type="text" value="{{$user->userFullName}}" required name="name">
							@error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
						</div>
						<div class="col-md-6">
							<label class="f-12">Mobile Number</label>
							<input class="form-control @error('mobile') is-invalid @enderror" type="text" value="{{$user->userMobile}}" required name="mobile">
							@error('mobile')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
						</div>
						<div class="col-md-6">
							<label class="f-12">Email</label>
							<input class="form-control @error('email') is-invalid @enderror" type="email" value="{{$user->userEmail}}" required name="email">
							@error('email')
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