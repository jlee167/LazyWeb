<?php


namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;



class UserController extends Controller
{
    /**
     *  - Summary
     *      Retrieve a user's unique id from his/her username
     *
     *  @param string $username     unique username of an user
     */
    static public function __get_id_by_username($username) {
        $query_result = DB::table('users')
                            ->where('username', '=', (string)$username)
                            ->get('id');
        return json_encode($query_result);
    }


    /**
     *  - Summary
     *      Retrieve a user's information based on username
     *
     *  @param string $username     unique username of an user
     */
    static public function get_user($username) {
        /*  Retrieve a user specified by id
            Query returns empty set or a single user */
        $query_result = DB::table('users')
                            ->where('username', '=', (string)$username)
                            ->get();

        /* Todo: return only relevant information */
        return json_encode($query_result);
    }


    /**
     *  - Summary
     *      Register a new user into database.
     *
     *  @param object $user_info     unique username of an user
     */
    static public function register_user($user_info) {
        $query_result = DB::table('users')
                            ->insert([
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
                                'status'        => 'FINE',
                                'response'      => 'RESOLVED',
                                'privacy'       => $user_info->privacy,
                                'proxy_enable'  => $user_info->proxy_enable,
                                'password_hint' => $user_info->password_hint,
                                'hint_answer'   => $user_info->hint_answer
                            ]);
    }


    /**
     *  - Summary
     *      Delete a user from database
     *
     *  @param string $username     unique username of an user
     *
     */
    static public function delete_user($username) {
        /*  Retrieve a user specified by id
            Query returns empty set or a single user */
            $query_result = DB::table('users')
            ->where('username', '=', (string)$username)
            ->delete();

        /* Todo: Determine what to return after deletion */
        return json_encode($query_result);
    }


    /**
     *  - Summary
     *      Update a user's record
     *
     *  @param string $username     unique username of an user
     *
     */
    static public function update_user($uid, $user_info) {
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


    public function get_my_account(){
        $this->get_user(Auth::id());
    }


    public function delete_my_account(){
        $this->delete_user(Auth::id());
    }


    public function update_my_account(Request $request, $uid){
        $this->update_user($request->my_info, Auth::id());
    }



    /*******************************************
     *  Friendship management APIs
     *******************************************/

     /**
     * Return all friends of a user
     *
     * @param   request
     * @return  json        // Json object containing current user's friend list
     */
    static public function get_friends(Request $request) {
        $result =
            DB::table('users')
            ->select('firstname', 'lastname', 'email', 'username')
            ->where('users.id', function ($query_friends) {
                $query_friends
                    ->select('uid_user2')
                    ->from('friendship')
                    ->where('uid_user1', '=', Auth::id());
            })
            ->get();
        return json_encode($result);
    }


    /**
     * Send a friend request to the user specified by uid
     *
     * @param   uid     // Id of the user to send friend request to
     * @return  void
     */
    static public function add_friend(Request $request, $uid) {
        $result = DB::table('friendship')
                    -> insert([
                        'uid_user1' => Auth::id(),
                        'uid_user2' => $uid
                    ]);
    }


    /**
     * Accept a friend request
     *
     * @param   uid     // Id of the user who sent the request
     * @return  bool    //
     */
    static public function respond_friend_request(Request $request, $uid) {
        $result = DB::table('friendship')
                    ->where ('uid_user1', '=', strval($uid))
                    ->where ('uid_user2', '=', Auth::id())
                    ->update([
                        'signed_user2' => strval($request->response)
                    ]);
        return($result);
    }



    /**
     * Remove a user from friendlist
     *
     * @param   uid     // Id of the user to be deleted from friendlist
     * @return  void
     */
    static public function delete_friend(Request $request, $uid) {
        $result = DB::table('friendship')
        ->where(function ($query) {
            $query
            ->where('uid_user1', '=', Auth::id())
            ->orWhere('uid_user2', '=', Auth::id());
        })
        ->where(function ($query) use ($uid) {
            $query
            ->where('uid_user1', '=', $uid)
            ->orWhere('uid_user2', '=', $uid);
        })
        ->delete();
    }





    /*******************************************
     *  Guardianship management APIs
     *******************************************/

    /**
     * Return all guardians of a user
     *
     * @param   request
     * @return  json        // Json object containing current user's guardian list
     */
    static public function get_guardians(Request $request) {
        $result =
            DB::table('users')
            ->select('firstname', 'lastname', 'email', 'username')
            ->where('users.id', function ($query_friends) {
                $query_friends
                    ->select('uid_guardian')
                    ->from('guardianship')
                    ->where('uid_protected', '=', Auth::id());
            })
            ->get();
        return json_encode($result);
    }


    /**
     * Send a guardianship request to the user specified by uid
     *
     * @param   uid     // Id of the user to send guardianship request to
     * @return  void
     */
    static public function add_guardian(Request $request, $uid) {
        $result = DB::table('guardianship')
                    -> insert([
                        'uid_protected' => Auth::id(),
                        'uid_guardian' => $uid,
                        'signed_protected' => '1'
                    ]);
    }


    /**
     * Accept a guardianship request
     *
     * @param   uid     // Id of the user who sent the request
     * @return  bool    //
     */
    static public function confirm_guardian_request(Request $request, $uid) {
        $result = DB::table('guardianship')
                    ->where ('uid_protected', '=', strval($uid))
                    ->where ('uid_guardian', '=', Auth::id())
                    ->update([
                        'signed_guardian' => strval($request->response)
                    ]);
        return(strval($request->response));
    }


    /**
     * Remove a user from guardian group
     *
     * @param   uid     // Id of the user to be deleted from friendlist
     * @return  void
     */
    static public function delete_guardian(Request $request, $uid) {
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
    static public function get_protecteds(Request $request) {
        $result =
            DB::table('users')
            ->select('firstname', 'lastname', 'email', 'username')
            ->where('users.id', function ($query_friends) {
                $query_friends
                    ->select('uid_protected')
                    ->from('guardianship')
                    ->where('uid_guardian', '=', Auth::id());
            })
            ->get();
        return json_encode($result);
    }


    /**
     * Invite a user to current user's guardianship
     *
     * @param   uid     // Id of the user to send request to
     * @return  void
     */
    static public function add_protected(Request $request, $uid) {
        $result = DB::table('guardianship')
                    -> insert([
                        'uid_guardian' => Auth::id(),
                        'uid_protected' => $uid,
                        'signed_protected' => '1'
                    ]);
    }


    /**
     * Accept a protection request
     *
     * @param   uid     // Id of the user who sent the request
     * @return  bool    //
     */
    static public function confirm_protected_request(Request $request, $uid) {
        $result = DB::table('guardianship')
                    ->where ('uid_guardian', '=', strval($uid))
                    ->where ('uid_protected', '=', Auth::id())
                    ->update([
                        'signed_guardian' => strval($request->response)
                    ]);
        return(strval($request->response));
    }


    /**
     * Remove a user from protected client group
     *
     * @param   uid     // Id of the user to be deleted from client list
     * @return  void
     */
    static public function delete_protected(Request $request, $uid) {
        $result = DB::table('guardianship')
        ->where('uid_guardian', '=', Auth::id())
        ->where('uid_protected', '=', strval($uid))
        ->delete();
    }




    /*******************************************
     *  Emergency system management APIs
     *******************************************/

     /**
     * File emergency report
     *
     * @return  void
     */
    static public function emergency_report(Request $request){
        $result = DB::table('reports')
                    -> insert([
                        'uid' => Auth::id(),
                        'status' => 'DANGER_URGENT_RESPONSE',
                        'response' => 'RESPONSE_REQUIRED',
                        'responders' => strval (
                            DB::table('guardianship')
                                ->select('uid_guardian')
                                ->where('uid_protected', Auth::id())
                                ->get()
                        ),
                        'stream_key' => Hash::make("secret"),
                        'description' => $request->extra_message,
                    ]);
        return $result;
    }


    /**
     * Query a user's status
     *
     * @return  void
     */
    static public function get_status($uid){
        if  (!empty(DB::table('guardianship')
                ->where('uid_guardian', Auth::id())
                ->where('uid_protected', $uid)
                ->get())
            or
            Auth::id() == $uid
        ){
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
    static public function get_streamkey($uid){
        if  (!empty(DB::table('guardianship')
                ->where('uid_guardian', Auth::id())
                ->where('uid_protected', $uid)
                ->get())
            or
            Auth::id() == $uid
        ){
            return  json_encode(DB::table('reports')
                        ->select('stream_key')
                        ->where('uid', $uid)
                        ->get());
        }
    }
}
