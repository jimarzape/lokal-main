<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\MainController;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Auth;
use App\User;
use App\Model\Cart;
use App\Model\BarangayModel;
use App\Model\CityModel;
use App\Model\ProvinceModel;
use Illuminate\Support\Facades\Hash;


class AccountController extends MainController
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            $this->u = Auth::user();
            if(isset( Auth::User(  )->userId ))
            {
                $cart = Cart::byuser(Auth::user()->userId)->sum('quantity');
                $this->data['cart_qty'] = $cart;
            }
            else
            {
                $this->data['cart_qty'] = 0;
            }
            return $next($request);
        });
    }

    public function index()
    {
    	$this->data['user'] = Auth::user();
    	return view('auth.account', $this->data);
    }

    public function update_info(Request $request)
    {
    	
        $validator = Validator::make($request->all(), 
        	[
	            'name' => 'required|min:6|max:255|string',
	            'email' => 'required|unique:users,userEmail,' . Auth::user()->userId.',userId',
	            'mobile' => 'required|unique:users,userMobile,'. Auth::user()->userId.',userId',
	        ],
	        [
            	'name.required' => 'Your name is required.',
            	'name.max' => 'Your name must be lower than 255 characters.',
            	'email.required' => 'Your email is required.',
            	'email.userEmail' => 'Email is not in valid format.',
            	'email.max' => 'Email must be lower than 255 characters.',
            	'email.unique' => 'Email already been used.',
            	'mobile.required' => 'Mobile number is required',
            	'mobile.unique' => 'Mobile already been used',
        	]
	    );

	    if($validator->fails())
	    {
	    	return redirect()->route('account')->withErrors($validator->messages())->withInput($request->input());
	    }
	    else
	    {
	    	$user 				= new User;
	    	$user->exists 		= true;
	    	$user->userId 		= Auth::user()->userId;
	    	$user->userEmail 	= $request->email;
	    	$user->userMobile	= $request->mobile;
	    	$user->userFullName = $request->name;
	    	$user->save();
	    	return redirect()->route('account')->with('success', 'Acount information has been updated successfully');
	    }
    	// return redirect()->back();
    }

    public function manage_password()
    {
    	$this->data['user'] = Auth::user();
    	return view('auth.password',$this->data);
    }

    public function shipping()
    {
    	$barangay 	= array();
    	$city 		= array();
    	$province 	= ProvinceModel::where('provDesc', Auth::user()->userProvince)->first();
    	if(!is_null($province))
    	{
    		$city 		= CityModel::where('provCode', $province->provCode)->orderBy('citymunDesc')->get();
    		$city_user	= CityModel::where('provCode', $province->provCode)->where('citymunDesc',Auth::user()->userCityMunicipality)->first();
    		if(!is_null($city_user))
    		{
    			$barangay = BarangayModel::where('citymunCode',$city_user->citymunCode)->orderBy('brgyDesc')->get();
    		}
    	}
    	$this->data['_province'] 	= ProvinceModel::orderBy('provDesc')->get();
    	$this->data['_city']		= $city;
    	$this->data['_brgy']		= $barangay;
    	$this->data['user'] 		= Auth::user();
    	return view('auth.shipping',$this->data);
    }

    public function update_shipping(Request $request)
    {
    	$user 						= new User;
    	$user->exists 				= true;
    	$user->userId 				= Auth::user()->userId;
    	$user->userShippingAddress 	= $request->street;
    	$user->userBarangay 		= $request->barangay;
    	$user->userCityMunicipality = $request->city;
    	$user->userProvince			= $request->province;
    	$user->save();

    	return redirect()->route('user_shipping')->with('success', 'Shipping/Billing address has been updated successfully');
    }

    public function update_password(Request $request)
    {
        $checker = Hash::check($request->oldpassword, Auth::user()->password);
        if($checker)
        {
            if($request->password != $request->confirmpassword)
            {
                $error['password'] = 'Password did not match';
                $error['confirmpassword'] = 'Password did not match';
                return redirect()->route('manage_password')->withErrors($error);
            }
            else
            {
                $user = new User;
                $user->exists = true;
                $user->userId = Auth::user()->userId;
                $user->password = Hash::make($request->password);
                $user->save();
                return redirect()->route('manage_password')->with('success', 'Password has been updated successfully');
            }
        }
        else
        {
            return redirect()->route('manage_password')->withErrors(['oldpassword' => 'Old password did not match.']);
        }
    }

    public function city(Request $request)
    {
    	try
    	{
    		$city = CityModel::select('citymunCode as code','citymunDesc as name')->where('provCode', $request->code)->orderBy('name')->get();
    		return response()->json($city);
    	}
    	catch(\Exception $e)
    	{
    		return response()->json($e->getMessage(), 500);
    	}
    	
    }

    public function brgy(Request $request)
    {
    	try
    	{
    		$brgy = BarangayModel::select('brgyCode as code','brgyDesc as name')->where('citymunCode', $request->code)->orderBy('name')->get();
    		return response()->json($brgy);
    	}
    	catch(\Exception $e)
    	{
    		return response()->json($e->getMessage(), 500);
    	}
    	
    }

    
}
