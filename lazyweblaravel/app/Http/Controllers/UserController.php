<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redis;
use App\Http\Controllers\OauthController as Oauth;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Http;

class UserController extends Controller
{
    /**
     *  Retrieve a user's id number from its username
     *
     *  @param string $username     unique username of an user
     */
    static public function getUserId($username)
    {
        $query_result = DB::table('users')
            ->where('username', '=', (string)$username)
            ->get('id');
        return json_encode($query_result);
    }


    /**
     *  Retrieve a user's information based on username
     *
     *  @param string $username     unique username of an user
     */
    static public function getUser($username)
    {
        if (Auth::check()) {
            if (Auth::user() == $username) {
                $query_result = DB::table('users')
                    ->where('username', '=', (string)$username)
                    ->get();

                /* Todo: return only relevant information */
                return json_encode($query_result);
            }
        } else {
            /* Todo: Give less info */
        }
    }



    /**
     * Register a new user into database.
     *
     * @param  mixed $request
     * @param  mixed $username
     * @return JSON
     */
    static public function registerUser(Request $request, $username)
    {
        $duplicateUname = DB::table('users')
            ->where('username', '=', $username)
            ->first();
        if ($duplicateUname) {
            return json_encode([
                'registered' => false,
                'error'     => 'Existing Username!'
            ]);
        }

        $duplicateEmail = DB::table('users')
            ->where('email', '=', $request->email)
            ->first();
        if ($duplicateEmail) {
            return json_encode([
                'registered' => false,
                'error'     => 'Existing Email!'
            ]);
        }


        try {
            $uid_oauth = null;
            if ($request->auth_provider == 'Google') {
                $user = Oauth::getGoogleUser($request->accessToken);
                $uid_oauth = $user['uid'];
            } else if ($request->auth_provider == 'Kakao') {
                $user = Oauth::getKakaoUser($request->accessToken);
                $uid_oauth = $user['uid'];
            }

            if ($request->auth_provider != 'None') {
                $catch_duplicate_oauth = DB::table('users')
                    ->where('auth_provider', '=', $request->auth_provider)
                    ->where('uid_oauth', '=', $uid_oauth)
                    ->first();
                if ($catch_duplicate_oauth) {
                    return json_encode([
                        'registered' => false,
                        'error'     => 'Already registered social login account!'
                    ]);
                }
            }



            $query_result = DB::table('users')->insert(
                [
                    'username'      => $username,
                    'password'      => Hash::make($request->password),
                    'email'         => $request->email,
                    'auth_provider' => $request->auth_provider,
                    'uid_oauth'     => $uid_oauth,
                    'stream_key'    => str_random(32)
                ]
            );

            Http::get("http://127.0.0.1:3001/jwtgen/".$username);

            if ($query_result)
                return json_encode([
                    'registered' => true
                ]);
            else
                return json_encode([
                    'registered' => false,
                ]);
        } catch (QueryException $e) {
            dd($e);
            return json_encode([
                'registered' => false,
                'error' => "Unexpected database query exception occured"
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
    static public function updateUser(Request $request, $username)
    {
        $query_result = DB::table('users')
            ->where('username', '=', (string)$username)
            ->update([
                'firstname'     => $request->firstname,
                'lastname'      => $request->lastname,
                'username'      => $request->username,
                'password'      => Hash::make($request->password),
                'auth_provider' => $request->auth_provider,
                'id_external'   => $request->id_external,
                'faceshot_url'  => $request->faceshot_url,
                'email'         => $request->email,
                'cell'          => $request->cell,
                'stream_id'     => $request->stream_id,
                'status'        => $request->status,
                'response'      => $request->response,
                'privacy'       => $request->privacy,
                'proxy_enable'  => $request->proxy_enable,
                'password_hint' => $request->password_hint,
                'hint_answer'   => $request->hint_answer
            ]);

        if ($query_result)
            return json_encode([
                'updated' => true
            ]);
        else
            return json_encode([
                'updated' => false,
            ]);
    }




    /**
     *  Delete a user from database
     *
     *  @param string $username     unique username of an user
     *
     */
    static public function deleteUser($username)
    {
        $query_result = DB::table('users')->insert(
            [
                'id' => Auth::id()
            ]
        );

        /* Todo: Determine what to return after deletion */
        return json_encode($query_result);
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
    static public function getGuardians(Request $request)
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
    static public function addGuardian(Request $request, $uid)
    {
        try {
            $result = DB::table('guardianship')
                ->insert([
                    'uid_protected' => Auth::id(),
                    'uid_guardian' => $uid,
                    'signed_protected' => 'ACCEPTED'
                ]);
            return json_encode([
                'status'    => 'ok',
                'error'     => null
            ]);
        } catch (\Illuminate\Database\QueryException $e) {
            return json_encode([
                'status'    => 'error',
                'error'     => (string) $e
            ]);
        }
    }



    /**
     * respondPeerRequest
     *
     * @param  Request  $request
     * @return void
     */
    static public function respondPeerRequest(Request $request)
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
    static public function getPendingRequests(Request $request)
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
    static public function deleteGuardian(Request $request, $uid)
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
    static public function getProtecteds(Request $request)
    {
        $username = Auth::user()->username;
        $result = DB::select("CALL GetProtecteds('${username}')");
        return json_encode($result);
    }


    /**
     * Invite a user to current user's guardianship
     *
     * @param   uid     // Id of the user to send request to
     * @return  void
     */
    static public function addProtected(Request $request, $uid)
    {
        try {
            $result = DB::table('guardianship')
                ->insert([
                    'uid_protected' => $uid,
                    'uid_guardian' => Auth::id(),
                    'signed_guardian' => 'ACCEPTED'
                ]);
            return json_encode([
                'status'    => 'ok',
                'error'     => null
            ]);
        } catch (\Illuminate\Database\QueryException $e) {
            return json_encode([
                'status'    => 'error',
                'error'     => (string) $e
            ]);
        }
    }


    /**
     * Remove a user from protected client group
     *
     * @param   uid     // Id of the user to be deleted from client list
     * @return  void
     */
    static public function deleteProtected(Request $request, $uid)
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
    static public function emergency_report(Request $request)
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
                )
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
    static public function getStatus($uid)
    {
        if (
            !empty(DB::table('guardianship')
                ->where('uid_guardian', Auth::id())
                ->where('uid_protected', $uid)
                ->get())
            or
            Auth::id() == $uid
        ) {
            return  json_encode(DB::table('reports')
                ->select('status')
                ->where('uid', $uid)
                ->get());
        }
    }


    /**
     * Get a protected client's stream key
     *
     * @return  void
     */
    static public function getStreamToken($uid)
    {
        if (
            !empty(DB::table('guardianship')
                ->where('uid_guardian', Auth::id())
                ->where('uid_protected', $uid)
                ->get())
            or
            Auth::id() == $uid
        ) {
            $stream_tokens = REDIS::get('stream_' . (string)$uid);
            //@Todo
            $user_token = $stream_tokens['index'];
            unset($stream_tokens);
            return $stream_tokens;
        }
    }

    /* -------------------------------------------------------------------------- */
    /*                      /Emergency system management APIs                     */
    /* -------------------------------------------------------------------------- */

}
