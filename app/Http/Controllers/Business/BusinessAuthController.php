<?php

namespace App\Http\Controllers\Business;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Twilio\Rest\Voice;

class BusinessAuthController extends Controller
{

    public function __construct()
    {
        $this->middleware('guest')->except(['business.dashboard', 'business.logout']);
    }
    public function login(): View
    {
        return \view('business.login');
    }

    public function loginPost(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::guard('business')->attempt(['email' => $request->email, 'password' => $request->password], $request->get('remember')))
        {

            return to_route('business.dashboard');
        }

        return back()->with('error', 'Email or Password are incorrect !');

    }

}
