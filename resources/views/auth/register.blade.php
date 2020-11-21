@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <h1 class="text-center text-theme mb-1m">Sign Up</h1>
           <div class="row signup-container mb-2m">
               <div class="col-md-6 bg-theme text-center text-white">
                   <img src="/media/img/logo-white.png" class="logo-signup mt-6m">
                   <div class="signup-hr"></div>
                   <span class="signup-span mb-1m">Sing Up With</span>
                   <div class="row justify-content-center mb-2m">
                       <div class="col-md-8">
                           <button class="btn btn-block fb-btn">SIGN IN WITH FACEBOOK</button>
                       </div>
                       <div class="col-md-8">
                           <button class="btn btn-block google-btn">SIGN IN WITH GOOGLE</button>
                       </div>
                   </div>
               </div>
               <div class="col-md-6 bg-white ">
                    <form method="POST" action="{{ route('register') }}" class="row pd-2m">
                        @csrf
                       <div class="col-md-12">
                           <div class="form-group">
                               <label for="name" class=" col-form-label text-md-right f-12">{{ __('Full Name') }}</label>
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="Enter your full name here">

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                           </div>
                            <div class="form-group">
                                <label for="email" class="col-form-label text-md-right f-12">Mobile Number</label>
                                <input id="mobile" type="text" class="form-control" name="mobile" value="{{ old('mobile') }}" required autocomplete="mobile" placeholder="Enter your mobile no. here">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                           </div>
                           <div class="form-group">
                                <label for="email" class="col-form-label text-md-right f-12">{{ __('E-Mail Address') }}</label>
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="Enter your email address here">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                           </div>
                           <div class="form-group">
                                <label for="password" class="col-form-label text-md-right f-12">{{ __('Password') }}</label>
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="Type your password here">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                           </div>
                           <div class="form-group">
                                <label for="password-confirm" class="col-form-label text-md-right f-12">{{ __('Confirm Password') }}</label>
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" placeholder="Confirm your password here">
                           </div>
                           <div class="form-group text-center">
                               <p class="f-12">By clicking "Register" you agreed to <a href="#">Terms & Conditions</a></p>
                           </div>
                           <div class="form-group">
                               <button class="btn btn-block btn-theme">SIGN UP</button>
                           </div>
                           <div class="form-group text-center">
                               <p class="f-12">Already have an account? Login <a href="{{ route('login') }}">here</a></p>
                           </div>
                       </div>
                   </form>
               </div>
           </div>
        </div>
    </div>
</div>
@endsection
