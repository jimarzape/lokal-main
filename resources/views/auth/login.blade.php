@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <h1 class="text-center text-theme mb-1m">Sign In</h1>
           <div class="row signup-container mb-2m">
               <div class="col-md-6 bg-theme text-center text-white">
                   <img src="/media/img/logo-white.png" class="logo-signup mt-2m">
                   <div class="signup-hr"></div>
                   <span class="signup-span mb-1m">Sing In With</span>
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
                    <form method="POST" action="{{ route('signin') }}" class="row pd-2m">
                        @csrf
                       <div class="col-md-12">
                           <div class="form-group">
                                <label for="userEmail" class=" col-form-label text-md-right">{{ __('E-Mail Address') }}</label>
                                <input id="userEmail" type="email" class="form-control @error('userEmail') is-invalid @enderror" name="userEmail" value="{{ old('userEmail') }}" required autocomplete="email" autofocus>

                                @error('userEmail')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                           </div>
                            <div class="form-group">
                                <label for="password" class=" col-form-label text-md-right">{{ __('Password') }}</label>
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required>

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                           </div>
                           <div class="form-group">
                                <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                <label class="form-check-label" for="remember">
                                    {{ __('Remember Me') }}
                                </label>
                            </div>
                           </div>
                           
                           <div class="form-group">
                               <button class="btn btn-block btn-theme">SIGN IN</button>
                           </div>
                           <div class="form-group text-center">
                               <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                </a>
                           </div>
                       </div>
                   </form>
               </div>
           </div>
        </div>
    </div>
</div>
@endsection
