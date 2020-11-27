@extends('layouts.app')

@section('content')
<div class="row">
	<div class="col-md-3">
		<p>Hello {{$user->userFullName}}</p>
		<div class="row">
			<div class="col-md-12">
				<ul>
					<li>
						<div>Account</div>
						<ul>
							<li>Profile</li>
							<li>Billing/Shipping Address</li>
							<li>Manage Password</li>
						</ul>
					</li>
					<li>
						Order History
					</li>
					<li>
						Want List
					</li>
					<li>
						Following Store
					</li>
					<li>
						Reviews
					</li>
				</ul>
			</div>
		</div>
	</div>
	<div class="col-md-9">
		<div class="row">
			<div class="col-md-4">
				<div class="card">
					<div class="card-body"></div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
