<?php

namespace App\Http\Controllers;

use App\Http\Controllers\OauthController;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redis;
use PragmaRX\Google2FA\Google2FA;


class UserController extends OauthController
{
    /**
     *  Retrieve a user's id number from its username
     *
     *  @param string $username     unique username of an user
     */
    public static function getUserId(Request $request, $username)
    {
        /* Register user into database */
        $user = User::where('username', '=', (string) $username)
                    ->get('id');

        return json_encode($user);
    }

    /**
     *  Retrieve a user's information based on username
     *
     *  @param string $username     unique username of an user
     */
    public static function getUser(Request $request, $username)
    {
        if (Auth::check()) {
            if (Auth::user() == $username) {
                $query_result = User::where('username', '=', (string) $username)
                                ->get();

                /* Todo: return only relevant information */
                return json_encode($query_result);
            }
        } else {
            /* Todo: Give less info */
        }
    }


    public function getMyInfo(Request $request) {
        $user = User::where('id', '=', Auth::id())
            ->first();
        $is2FAenabled = ($user->google2fa_secret != null);

        return json_encode([
            'id' => $user->id,
            'username' => $user->username,
            'email' => $user->email,
            '2fa' => $is2FAenabled,
            'auth_provider' => $user->auth_provider
        ]);
    }


    public function resendEmail(Request $request) {

        /* Send email verification link */
        $request->user()->sendEmailVerificationNotification();
        return json_encode([
            'result' => true
        ]);
    }

    /**
     * Register a new user into database.
     *
     * @param  mixed $request
     * @param  mixed $username
     * @return JSON
     */
    public function registerUser(Request $request, $username)
    {

        $validated = $this->validateUserInfo($request);

        $duplicateUname = User::where('username', '=', $username)
                            ->first();
        if ($duplicateUname) {
            return json_encode([
                'registered' => false,
                'error' => 'Existing Username!',
            ]);
        }

        $duplicateEmail = User::where('email', '=', $request->email)
                            ->first();
        if ($duplicateEmail) {
            return json_encode([
                'registered' => false,
                'error' => 'Existing Email!',
            ]);
        }

        if (empty($request->image_url)) {
            $request->imageurl = User::DEFAULT_IMAGE_URL;
        }

        try {
            $uid_oauth = null;
            if ($request->auth_provider == 'Google') {
                \Firebase\JWT\JWT::$leeway = 5;
                $user = $this->getGoogleUser($request->accessToken);
                $uid_oauth = $user['uid'];
            } else if ($request->auth_provider == 'Kakao') {
                $user = $this->getKakaoUser($request->accessToken);
                $uid_oauth = $user['uid'];
            }

            if ($request->auth_provider != 'None') {
                $catch_duplicate_oauth = User::where('uid_oauth', '=', $uid_oauth)
                                            ->where('auth_provider', '=', $request->auth_provider)
                                            ->first();
                if ($catch_duplicate_oauth) {
                    return json_encode([
                        'registered' => false,
                        'error' => 'Already registered social login account!',
                    ]);
                }
            }

            /* Register user into database */
            $user = User::firstOrCreate([
                'username' => $username,
                'password' => Hash::make($request->password),
                'email' => $request->email,
                'auth_provider' => $request->auth_provider,
                'uid_oauth' => $uid_oauth,
                'stream_key' => str_random(32),
                'image_url' => $request->imageurl,
            ]);

            /* Send email verification link */
            event(new Registered($user));
            //Auth::attempt(['username' => $this->username, 'password' => $this->password]);

            //Http::get( env('STREAMING_SERVER', 'http://127.0.0.1:3001') . "/jwtgen/" . $username);

            if ($user) {
                return json_encode([
                    'registered' => true,
                ]);
            } else {
                return json_encode([
                    'registered' => false,
                    'msg' => "Already Registered",
                ]);
            }

        } catch (QueryException $e) {
            dd($e);
            return json_encode([
                'registered' => false,
                'error' => "Unexpected database query exception occured",
            ]);
        }
    }

    /**
     * Update current user's personal information.
     *
     * @param  mixed $request
     * @param  mixed $username
     * @return void
     */
    public static function updateUser(Request $request, $username)
    {

        try {
            $query_result = User::where('username', '=', (string) $username)
                                ->update([
                                    'firstname' => $request->firstname,
                                    'lastname' => $request->lastname,
                                    'username' => $request->username,
                                    'password' => Hash::make($request->password),
                                    'auth_provider' => $request->auth_provider,
                                    'email' => $request->email,
                                    'cell' => $request->cell,
                                    'status' => $request->status,
                                    'response' => $request->response,
                                    'privacy' => $request->privacy,
                                    'proxy_enable' => $request->proxy_enable,
                                    'password_hint' => $request->password_hint,
                                    'hint_answer' => $request->hint_answer,
                                ]);

            if ($query_result) {
                return json_encode([
                    'result' => true,
                ]);
            } else {
                return json_encode([
                    'result' => false,
                ]);
            }
        } catch (QueryException $e) {
            return json_encode([
                'result' => false
            ]);
        }

    }

    /**
     *  Delete a user from database
     *
     *  @param string $username     unique username of an user
     *
     */
    public function deleteUser()
    {
        try{
            User::where('id', '=', Auth::id())
                ->delete();
        } catch (QueryException $e) {
            return json_encode([
                'result' => false,
                'error' => "Database Failure"
            ]);
        }
        return json_encode([
            'result' => true
        ]);
    }


    public function enable2FA(Request $request, $username)
    {
        $user = User::where('username', '=', (string) $username)
                    ->get();

        Google2FA::setQRCodeBackend('svg');

        if ($user->google2fa_secret === null) {
            $google2fa = (new \PragmaRX\Google2FAQRCode\Google2FA());
            $user->google2fa_secret = $google2fa->generateSecretKey();
            $user->save();

            $qrCodeUrl = $google2fa->getQRCodeInline(
                'Lazyboy Industries',
                'lazyboyindustries.main@gmail.com',
                $user->google2fa_secret
            );

            return json_encode([
                'result' => true,
                'qrCodeUrl' => $qrCodeUrl
            ]);
        } else {
            return json_encode([
                'result' => false,
                'error' => "You already have Google OTP key"
            ]);
        }
    }

    public function disable2FA(Request $request, $username)
    {
        try {
            $user = User::where('username', '=', (string) $username);
            $user->google2fa_secret = null;
            $user->save();
            return json_encode([
                'result' => true,
            ]);
        } catch (QueryException | Exception $e) {

        }
    }


    /**
     * Change user password
     * @Todo: enforce max password change limit per day
     *
     * @param  mixed $request
     * @return void
     */
    public function changePassword(Request $request)
    {
        $user = User::where('id', '=', Auth::id())
                    ->first();
        if (!Hash::check($request->currentPassword, $user->password))
            return json_encode([
                'result' => false,
                'error' => "Incorrect Password"
            ]);

        if ($request->newPassword === $request->confirmPassword) {
            $user->password = Hash::make($request->newPassword);
            $user->save();

            /* Clear current session */
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return json_encode([
                'result' => true
            ]);
        } else {
            return json_encode([
                'result' => false,
                'error' => "Password confirmation error. Please check Confirm Password input."
            ]);
        }
    }



    private function validateUserInfo(Request $request)
    {
        return $request->validate([
            'username' => ['min:8'],
            'password' => ['min:8'],
            'email' => ['email:rfc,dns'],
        ]);
    }




    /* -------------------------------------------------------------------------- */
    /*                        Guardianship management APIs                        */
    /* -------------------------------------------------------------------------- */

    /**
     * Return all guardians of a user
     *
     * @param   Request $request
     * @return  JSON    (Current user's guardian list)
     */
    public static function getGuardians(Request $request)
    {
        $username = Auth::user()->username;
        $result = DB::select("CALL GetGuardians('${username}')");
        return json_encode($result);
    }

    /**
     * Send a guardianship request to the user specified by uid
     *
     * @param  Request  $request
     * @param  int      $uid
     * @return JSON     (result of guardianshp request)
     */
    public static function addGuardian(Request $request, $uid)
    {
        try {
            $result = DB::table('guardianship')
                ->insert([
                    'uid_protected' => Auth::id(),
                    'uid_guardian' => $uid,
                    'signed_protected' => 'ACCEPTED',
                ]);
            return json_encode([
                'status' => 'ok',
                'error' => null,
            ]);
        } catch (\Illuminate\Database\QueryException $e) {
            return json_encode([
                'status' => 'error',
                'error' => (string) $e,
            ]);
        }
    }

    /**
     * respondPeerRequest
     *
     * @param  Request  $request
     * @return void
     */
    public static function respondPeerRequest(Request $request)
    {
        $requestID = strval($request->input("requestID"));
        $uid = strval(Auth::id());
        $response = $request->input("response");

        $result = DB::select("CALL RespondPeerRequest('${requestID}','${uid}', '${response}')");
        return (strval($request->response));
    }

    /**
     * getPendingRequests
     *
     * @return void
     */
    public static function getPendingRequests(Request $request)
    {
        $uid = Auth::id();
        $result = DB::select("CALL GetPendingRequests('${uid}')");

        return json_encode($result);
    }

    /**
     * Remove a user from guardian group
     *
     * @param   uid     // Id of the user to be deleted from friendlist
     * @return  void
     */
    public static function deleteGuardian(Request $request, $uid)
    {
        $result = DB::table('guardianship')
            ->where('uid_protected', '=', Auth::id())
            ->where('uid_guardian', '=', strval($uid))
            ->delete();
    }

    /**
     * Return all protected clients of a user
     *
     * @param   request
     * @return  json        // Json object containing current user's protected client list
     */
    public static function getProtecteds(Request $request)
    {
        try {
            $username = Auth::user()->username;
            $result = DB::select("CALL GetProtecteds('${username}')");
            return json_encode($result);
        } catch (Exception $e) {
            return json_encode($e);
        }
    }

    /**
     * Invite a user to current user's guardianship
     *
     * @param   uid     // Id of the user to send request to
     * @return  void
     */
    public static function addProtected(Request $request, $uid)
    {
        try {
            $result = DB::table('guardianship')
                ->insert([
                    'uid_protected' => $uid,
                    'uid_guardian' => Auth::id(),
                    'signed_guardian' => 'ACCEPTED',
                ]);
            return json_encode([
                'status' => 'ok',
                'error' => null,
            ]);
        } catch (\Illuminate\Database\QueryException $e) {
            return json_encode([
                'status' => 'error',
                'error' => (string) $e,
            ]);
        }
    }

    /**
     * Remove a user from protected client group
     *
     * @param   uid     // Id of the user to be deleted from client list
     * @return  void
     */
    public static function deleteProtected(Request $request, $uid)
    {
        $result = DB::table('guardianship')
            ->where('uid_guardian', '=', Auth::id())
            ->where('uid_protected', '=', strval($uid))
            ->delete();
    }

    /* -------------------------------------------------------------------------- */
    /*                        /Guardianship management APIs                       */
    /* -------------------------------------------------------------------------- */




    /* -------------------------------------------------------------------------- */
    /*                      Emergency system management APIs                      */
    /* -------------------------------------------------------------------------- */

    /**
     * File emergency report
     *
     * @return  void
     *
     * @deprecated
     *      Not used by web server anymore.
     *      Stream server implements this functionality instead.
     */
    public static function emergencyReport(Request $request)
    {
        DB::table('reports')
            ->insert([
                'uid' => Auth::id(),
                'status' => 'DANGER_URGENT_RESPONSE',
                'response' => 'RESPONSE_REQUIRED',
                'stream_key' =>
                json_decode(DB::table('users')
                        ->select('stream_key')
                        ->where('id', Auth::id())
                        ->get())[0]->stream_key,
                'responders' => strval(
                    DB::table('guardianship')
                        ->select('uid_guardian')
                        ->where('uid_protected', Auth::id())
                        ->get()
                ),
            ]);

        $result = DB::table('users')
            ->where('id', Auth::id())
            ->update(['status' => 'DANGER_URGENT']);

        return $result;
    }

    /**
     * Query a user's status
     *
     * @return  void
     */
    public static function getStatus($uid)
    {
        if (
            !empty(DB::table('guardianship')
                ->where('uid_guardian', Auth::id())
                ->where('uid_protected', $uid)
                ->get())
            or
            Auth::id() == $uid
        ) {
            return json_encode(DB::table('reports')
                    ->select('status')
                    ->where('uid', $uid)
                    ->get());
        }
    }


    /* -------------------------------------------------------------------------- */
    /*                      /Emergency system management APIs                     */
    /* -------------------------------------------------------------------------- */


}
