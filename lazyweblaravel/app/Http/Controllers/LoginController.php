<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Hash;
use Illuminate\Routing\Redirector;
use APP\Models\User;


class LoginController extends BaseController
{
    /**
     * Authenticate users with credentials extracted from HTTP request
     *
     * @param Request $request      // Contains login credentials
     */
    public function authenticate(Request $request)
    {
        if (Auth::check())
        {
            return json_encode([
                "token"             => Auth::check(),
                "href"              => route('main'),
                "authenticated"     => true,
            ]);
        }

        else
        {
            $this->auth_uname($request);
            /*
            switch ($request->auth_provider) {
                case 'Google':
                    auth_google($request);
                    break;
                case 'Kakao':
                    auth_kakao($request);
                    break;
                default:
                    auth_uname_password($request);
                    break;
            }
            */
        }
    }


    public function auth_uname(Request $request)
    {
        $username = $request->input('username');
        $password = $request->input('password');

        if (Auth::attempt(['username' => $username, 'password' => $password]))
        {
            //Auth::login($username);
            //Auth::logout(Auth::user());
            /*  Return session token and redirect URL to client.
                Client uses AJAX, so do not return redirect(). */
            $retval = [
                "token"             => Auth::check(),
                "href"              => route('main'),
                "authenticated"     => true,
            ];
            //$request->session()->put('mykey', 'myvalue');
        }
        else
        {
            $retval = [
                "token"           => "/",
                "href"            => "/",
                "authenticated"   => false,
            ];
        }

        return json_encode($retval);
    }


    public function auth_kakao(Request $request)
    {
        $access_token = $request->token;
        oauth_kakao($access_token);
    }


    public function auth_google(Request $request)
    {
        $access_token = $request->token;
        oauth_google($access_token);
    }


    /**
     * Authenticate users with Kakao tokens
     *
     * @param Request $request      // Contains login credentials
     */
    public function oauth_kakao(string $access_token){
        /*
            Make Rest API Request to Kakao.
            Response includes account information for user registration and sign in process.
		 */
		$authorization = 'Authorization: Bearer ' . $access_token;
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer ' . $access_token));
		curl_setopt($ch, CURLOPT_URL, 'https://kapi.kakao.com/v2/user/me');
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);

		// Get http response
		$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		curl_close($ch);

		//echo "access_token: " . $access_token . "\n";
		//echo 'http code: ' . $http_code . "\n";
		//echo $result;
		$result = json_decode($result, true);

		$uid = $result["id"];
		$name = $result["properties"]["nickname"];
		$email = $result["kakao_account"]["email"];
		$profile_picture = $result["kakao_account"]["profile"]["thumbnail_image_url"];

		if (!$result) {
			echo 'No response from Kakao Auth Server \n';
			exit;
		 }
    }


    /**
     * Authenticate users with Google tokens
     *
     * @param Request $request      // Contains login credentials
     */
    public function oauth_google(Request $request){

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
