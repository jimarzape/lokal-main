<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\MainController;
use Auth;
use App\User;

class AccountController extends MainController
{
    public function __construct()
    {

    }

    public function index()
    {
    	$this->data['user'] = Auth::user();
    	return view('auth.account', $this->data);
    }
}
