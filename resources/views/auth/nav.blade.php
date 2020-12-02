<div class="col-md-3">
<p class="f-bold">Hello {{$user->userFullName}}</p>

<ul class="list-profile-nav">
	<li>
		<div>Account</div>
		<ul class="no-list-style">
			<li class="{{isset($profile) ? 'active' : ''}}">
				<a href="{{route('account')}}">Profile</a>
			</li>
			<li class="{{isset($shipping_billing) ? 'active' : ''}}">
				<a href="{{route('user_shipping')}}">Billing/Shipping Address</a>
			</li>
			<li class="{{isset($manage_password) ? 'active' : ''}}">
				<a href="{{route('manage_password')}}">Manage Password</a>
			</li>
		</ul>
	</li>
	<li class="{{isset($order_history) ? 'active' : ''}}">
		<a href="{{route('order')}}">Order History</a>
	</li>
	<li class="{{isset($whish_list) ? 'active' : ''}}">
		<a href="{{route('wish')}}">Wish List</a>
	</li>
	<li class="{{isset($following_store) ? 'active' : ''}}">
		<a href="#">Following Store</a>
	</li>
	<li class="{{isset($reviews) ? 'active' : ''}}">
		<a href="#">Reviews</a>
	</li>
</ul>
	
</div>