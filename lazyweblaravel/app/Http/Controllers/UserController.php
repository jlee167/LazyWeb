<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redis;
use App\Http\Controllers\OauthTokenController as Oauth;




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
        /*  Retrieve a user specified by id
            Query returns empty set or a single user */
        $query_result = DB::table('users')
            ->where('username', '=', (string)$username)
            ->get();

        /* Todo: return only relevant information */
        return json_encode($query_result);
    }



    /**
     * Register a new user into database.
     *
     * @param  mixed $request
     * @param  mixed $username
     * @return void
     */
    static public function registerUser(Request $request, $username)
    {
        $catch_duplicate_uname = DB::table('users')
                            ->where('username', '=', $username)
                            ->first();
        if ($catch_duplicate_uname) {
            return json_encode([
                'registered'=> false,
                'error'     => 'Existing Username!'
            ]);
        }


        try{
            $uid_oauth = null;
            if ($request->auth_provider =='Google'){
                $user = Oauth::getGoogleUser($request->accessToken);
                $uid_oauth = $user['uid'];
            }
            else if ($request->auth_provider =='Kakao'){
                $user = Oauth::getKakaoUser($request->accessToken);
                $uid_oauth = $user['uid'];
            }

            if ($request->auth_provider != 'None')
            {
                $catch_duplicate_oauth = DB::table('users')
                                ->where('auth_provider', '=', $request->auth_provider)
                                ->where('uid_oauth', '=', $uid_oauth)
                                ->first();
                if ($catch_duplicate_oauth){
                    return json_encode([
                        'registered'=> false,
                        'error'     => 'Already registered social login account!'
                    ]);
                }
            }

            $query_result =
                DB::table('users')->insert(
                    [
                        'username'      => $username,
                        'password'      => Hash::make($request->password),
                        'auth_provider' => $request->auth_provider,
                        'uid_oauth'     => $uid_oauth,
                        'stream_key'    => str_random(32)
                    ]
            );

            if ($query_result)
                return json_encode([
                    'registered' => true
                ]);
            else
                return json_encode([
                    'registered' => false,
                ]);
        } catch (Exception $e) {
            return json_encode($e);
        }
    }


    /**
     *  - Summary
     *      Delete a user from database
     *
     *  @param string $username     unique username of an user
     *
     */
    static public function deleteUser($username)
    {
        /*  Retrieve a user specified by id
            Query returns empty set or a single user */
        $query_result = DB::table('users')
            ->where('username', '=', (string)$username)
            ->delete();

        /* Todo: Determine what to return after deletion */
        return json_encode($query_result);
    }



    /**
     * updateUser
     *
     * @param  mixed $uid
     * @param  mixed $user_info
     * @return void
     */
    static public function updateUser($uid, $user_info)
    {
        $query_result = DB::table('users')
            ->where('username', '=', (string)$uid)
            ->update([
                'firstname'     => $user_info->firstname,
                'lastname'      => $user_info->lastname,
                'username'      => $user_info->username,
                'password'      => Hash::make($user_info->password),
                'auth_provider' => $user_info->auth_provider,
                'id_external'   => $user_info->id_external,
                'faceshot_url'  => $user_info->faceshot_url,
                'email'         => $user_info->email,
                'cell'          => $user_info->cell,
                'stream_id'     => $user_info->stream_id,
                'status'        => $user_info->status,
                'response'      => $user_info->response,
                'privacy'       => $user_info->privacy,
                'proxy_enable'  => $user_info->proxy_enable,
                'password_hint' => $user_info->password_hint,
                'hint_answer'   => $user_info->hint_answer
            ]);
    }


    public function getUserAccount()
    {
        $this->getUser(Auth::id());
    }


    public function deleteUserAccount()
    {
        $this->deleteUser(Auth::id());
    }


    public function updateUserAccount(Request $request, $uid)
    {
        $this->updateUser($request->my_info, Auth::id());
    }




    /* -------------------------------------------------------------------------- */
    /*                        Guardianship management APIs                        */
    /* -------------------------------------------------------------------------- */

    /**
     * Return all guardians of a user
     *
     * @param   request
     * @return  json        // Json object containing current user's guardian list
     */
    static public function get_guardians(Request $request)
    {
        $username = Auth::user()->username;
        $result = DB::select("CALL GetGuardians('${username}')");
        return json_encode($result);
    }


    /**
     * Send a guardianship request to the user specified by uid
     *
     * @param   uid     // Id of the user to send guardianship request to
     * @return  void
     */
    static public function add_guardian(Request $request, $uid)
    {
        try {
            $result = DB::table('guardianship')
                ->insert([
                    'uid_protected' => Auth::id(),
                    'uid_guardian' => $uid,
                    'signed_protected' => '1'
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
     * Accept a guardianship request
     *
     * @param   uid     // Id of the user who sent the request
     * @return  bool    //
     */
    static public function acceptGuardian(Request $request, $uid)
    {
        $result = DB::table('guardianship')
            ->where('uid_protected', '=', strval($uid))
            ->where('uid_guardian', '=', Auth::id())
            ->update([
                'signed_protected' => strval($request->response)
            ]);
        return (strval($request->response));
    }


    /**
     * Accept a guardianship request
     *
     * @param   uid     // Id of the user who sent the request
     * @return  bool    //
     */
    static public function acceptProtected(Request $request, $uid)
    {

        $result = DB::table('guardianship')
            ->where('uid_guardian', '=', strval($uid))
            ->where('uid_protected', '=', Auth::id())
            ->update([
                'signed_guardian' => strval($request->response)
            ]);
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
    static public function delete_guardian(Request $request, $uid)
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
    static public function get_protecteds(Request $request)
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
    static public function add_protected(Request $request, $uid)
    {
        try {
            $result = DB::table('guardianship')
                ->insert([
                    'uid_protected' => $uid,
                    'uid_guardian' => Auth::id(),
                    'signed_guardian' => '1'
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
    static public function delete_protected(Request $request, $uid)
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
    static public function get_status($uid)
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
    static public function get_stream_token($uid)
    {
        if (
            !empty(DB::table('guardianship')
                ->where('uid_guardian', Auth::id())
                ->where('uid_protected', $uid)
                ->get())
            or
            Auth::id() == $uid
        ) {
            $stream_tokens = REDIS::get('stream_'.(String)$uid);
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
