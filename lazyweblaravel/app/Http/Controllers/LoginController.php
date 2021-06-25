<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Routing\Redirector;
use APP\Models\User;
use App\Http\Controllers\OauthController as Oauth;



class LoginController extends BaseController
{
    /**
     * Authenticate users with credentials extracted from HTTP request
     *
     * @param Request $request      // Contains login credentials
     */
    public function authenticate(Request $request)
    {
        if (Auth::check()) {
            return json_encode([
                "token"             => Auth::check(),
                "href"              => route('main'),
                "authenticated"     => true,
            ]);
        } else {
            return $this->authWithUname($request);
        }
    }


    /**
     * Check if current client is logged in.
     *
     * @return bool true if logged in. false if not.
     */
    public static function get_auth_state()
    {
        if (Auth::check())
            return true;
        else
            return false;
    }


    /**
     * Authenticate with Username
     *
     * @param  mixed    $request
     * @return string   authentication result (JSON Object)
     */
    public function authWithUname(Request $request)
    {
        $username = $request->input('username');
        $password = $request->input('password');

        if (Auth::attempt(['username' => $username, 'password' => $password])) {
            /*  Return session token and redirect URL to client.
                Client uses AJAX, so do not return redirect(). */
            $retval = [
                "token"             => Auth::check(),
                "href"              => route('main'),
                "authenticated"     => true,
            ];
            //$request->session()->put('mykey', 'myvalue');
        } else {
            $retval = [
                "token"           => "/",
                "href"            => redirect()->intended()->getTargetUrl(),
                "authenticated"   => false,
                "error"           => "Error: Invalid Credential!"
            ];
        }
        return json_encode($retval);
    }


    /**
     * authWithKakao
     *
     * @param  mixed $request
     * @return void
     */
    public function authWithKakao(Request $request)
    {
        $kakaoUser = Oauth::getKakaoUser($request->accessToken);
        $user = DB::table('users')
            ->where('auth_provider', '=', 'Kakao')
            ->where('uid_oauth', '=', $kakaoUser['uid'])
            ->first();

        try {
            if (Auth::loginUsingId($user->id)) {
                return json_encode([
                    "token"             => Auth::check(),
                    "href"              => route('main'),
                    "authenticated"     => true,
                ]);
            } else {
                return json_encode([
                    "token"             => Auth::check(),
                    "href"              => route('main'),
                    "authenticated"     => false,
                    "error"             => "Invalid Credential"
                ]);
            }
        } catch (\Exception $e) {
            return json_encode([
                "authenticated"     => false,
                "error"             => "Server Error: Unexpected exception"
            ]);
        }
    }


    /**
     * authWithGoogle
     *
     * @param  mixed $request
     * @return void
     */
    public function authWithGoogle(Request $request)
    {
        try {
            $client = new \Google_Client();
            $client->setClientId('494240878735-c8eo6b0m0t8fhd8vo2lcj0a9v6ena7bp.apps.googleusercontent.com');
            $client->setClientSecret('fGLi65s6_vDNunavqdCFrZom');
            if ($request->accessToken) {
                $payload = $client->verifyIdToken($request->accessToken);
            }

            if ($payload) {
                $uid = $payload['sub'];
                $email = $payload['email'];
                $verified = $payload['email_verified'];
                $name = $payload['name'];
                $profile_picture = $payload['picture'];
            } else {
                // Invalid ID token
                return "PHP server error: Invalid access token\n";
            }

            if ($verified == 0) {
                return 'Google token is not verified \n';
            }
        } catch (\Exception $e) {
            return "error@!";
        }


        $user = DB::table('users')
            ->where('auth_provider', '=', 'Google')
            ->where('uid_oauth', '=', $payload['sub'])
            ->first();

        if ($user == NULL)
            return json_encode([
                "token"             => Auth::check(),
                "href"              => route('main'),
                "authenticated"     => false,
                "error"             => "User does not exist!"
            ]);

        try {
            if (Auth::loginUsingId($user->id)) {
                return json_encode([
                    "token"             => Auth::check(),
                    "href"              => route('main'),
                    "authenticated"     => true,
                ]);
            } else {
                //@Todo
            }
        } catch (\Exception $e) {
            return json_encode([
                "authenticated"     => false,
                "error"             => "Server Error: Unexpected exception"
            ]);
        }
    }




    /**
     * Log out from session
     *
     * @param Request $request      // Contains login credentials
     */
    public function logout()
    {
        Auth::logout();
        $retval = [
            "status" => "success"
        ];

        return json_encode($retval);
    }
}
