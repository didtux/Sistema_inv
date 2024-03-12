<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Validation\ValidationException;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = RouteServiceProvider::HOME;

    protected function credentials(Request $request)
    {
        return array_merge($request->only($this->username(), 'password'), ['estado' => 1]);
    }
    protected function sendFailedLoginResponse(Request $request)
    {
        $user = Auth::user();
        
        if ($user && $user->estado == 1) {
            throw ValidationException::withMessages([
                $this->username() => [trans('auth.failed')],
            ]);
        } elseif (!$user) {
            throw ValidationException::withMessages([
                $this->username() => [trans('auth.failed')],
            ]);
        } else {
            throw ValidationException::withMessages([
                $this->username() => [trans('auth.inactive')],
            ]);
        }
    }
    

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
