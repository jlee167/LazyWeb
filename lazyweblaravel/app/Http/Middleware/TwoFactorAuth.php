<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use PragmaRX\Google2FALaravel\Facade as Google2FA;
use PragmaRX\Google2FALaravel\Support\Authenticator;
use PragmaRX\Google2FALaravel\Support\Constants as PackageConstants;
use PragmaRX\Google2FALaravel\Tests\Support\User;



class TwoFactorAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $user = \App\Models\User::where('id', '=', Auth::id())
                    ->first();

        if ($user->google2fa_secret === null) {
            /* This user does not use 2FA feature */
            return $next($request);
        }

        $authCheck = $request->getSession()->get('google2fa.auth_passed');
        if ($authCheck != true) {
            redirect()->guest(route('2fa'));
            return;
        }

        return $next($request);
    }
}
