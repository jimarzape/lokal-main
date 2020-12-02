@extends('layouts.app')

@section('content')
<div class="row">
	@php
		$shipping_billing = true;
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
							<label class="f-12">Province</label>
							<p>{{$user->userProvince}}</p>
						</div>
						<div class="col-md-4">
							<label class="f-12">City</label>
							<p>{{$user->userCityMunicipality}}</p>
						</div>
						<div class="col-md-4">
							<label class="f-12">Barangay</label>
							<p>{{$user->userBarangay}}</p>
						</div>
						<div class="col-md-4">
							<label class="f-12">Street</label>
							<p>{{$user->userShippingAddress}}</p>
						</div>
					</div>
				</div>
				<form class="card input-form hide" action="{{route('user_shipping_update')}}" method="POST">
					@csrf
					<div class="card-header text-right card-header-white">
						<a href="#" class="no-decoration hide-form">Cancel</a>
					</div>
					<div class="card-body">
						<div class="col-md-6">
							<label class="f-12">Province</label>
							<select class="form-control province-select address-select" required name="province" data-target=".city-select" data-url="{{route('city_api')}}">
								<option value="">Select Province</option>
								@foreach($_province as $province)
								<option data-value="{{$province->provCode}}" value="{{$province->provDesc}}" {{$province->provDesc == $user->userProvince ? 'selected' : ''}}>{{$province->provDesc}}</option>
								@endforeach
							</select>
						</div>
						<div class="col-md-6">
							<label class="f-12">City</label>
							<select class="form-control city-select address-select" required data-target=".brgy-select" name="city" data-url="{{route('brgy_api')}}">
								<option value="">Select City</option>
								@foreach($_city as $city)
								<option data-value="{{$city->citymunCode}}" value="{{$city->citymunDesc}}" {{$city->citymunDesc == $user->userCityMunicipality ? 'selected' : ''}}>{{$city->citymunDesc}}</option>
								@endforeach
							</select>
						</div>
						<div class="col-md-6">
							<label class="f-12">Barangay</label>
							<select class="form-control brgy-select" required name="barangay">
								<option value="">Select Barangay</option>
								@foreach($_brgy as $brgy)
								<option value="{{$brgy->brgyDesc}}" {{$brgy->brgyDesc == $user->userBarangay ? 'selected' : ''}}>{{$brgy->brgyDesc}}</option>
								@endforeach
							</select>
						</div>
						<div class="col-md-6">
							<label class="f-12">Street</label>
							<textarea class="form-control" name="street" required>{{$user->userShippingAddress}}</textarea>
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