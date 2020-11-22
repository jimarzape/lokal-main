<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Auth;
use App\User;

class SignInController extends Controller
{
    public function __construct()
    {

    }

    public function sign_in(Request $request)
    {
    	$user = User::where('userEmail', $request->userEmail)->first();
    	if(is_null($user))
    	{
    		$error['error'] = [
    			'userEmail' => 'Wrong email or password.'
    		];
    		return redirect()->route('login')->withInput($request->input())
    		 			  ->withErrors(['userEmail' => 'Email does not exists.']);
    	}
    	else
    	{
    		$checker = Hash::check($request->password, $user->password);
    		if($checker)
    		{
    			Auth::login($user);
    			return redirect()->intended('/');
    		}
    		else
    		{
    			$error['error'] = [
    			'userEmail' => 'Wrong email or password.'
	    		];
    			return redirect()->route('login')->withInput($request->input())
    						->withErrors(['password' => 'Password did not match.']);
    		}
    	}
    }

    public function signup(Request $request)
    {
    	$validator = Validator::make($request->all(), 
    		[
            	'userFullName' => ['required', 'string', 'max:255'],
	            'userEmail' => ['required', 'string', 'email', 'max:255', 'unique:users'],
	            'password' => ['required', 'string', 'min:8','confirmed'],
	            'userMobile' => ['required', 'unique:users']
        	], 
        	[
            	'userFullName.required' => 'Your name is required.',
            	'userFullName.max' => 'Your name must be lower than 255 characters.',
            	'userEmail.required' => 'Your email is required.',
            	'userEmail.email' => 'Email is not in valid format.',
            	'userEmail.max' => 'Email must be lower than 255 characters.',
            	'userEmail.unique' => 'Email is already exists.',
            	'password.required' => 'Password is required.',
            	'password.min' => 'Password should be more than 8 characters',
            	'password.confirmed' => 'Password does not match',
            	'userMobile.required' => 'Mobile number is required',
            	'userMobile.unique' => 'Mobile already exists',
        	]
        );
    	// dd($validator->messages());
        if($validator->fails())
        {
        	return redirect()->route('register')->withErrors($validator->messages())->withInput($request->input());
        }
        else
        {
        	$user = new User;
        	$user->userFullName = $request->userFullName;
        	$user->userEmail = $request->userEmail;
        	$user->userMobile = $request->userMobile;
        	$user->password = Hash::make($request->password);
        	$user->save();
        	Auth::login($user);

        	return redirect()->intended('/');
        }
    }
}
