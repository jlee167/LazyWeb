<?php

namespace App\Http\Controllers;

use APP\Models\Stream;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class StreamController extends Controller
{
    /**
     * getWebToken
     *
     * @param  mixed $username  /Protectee's username
     * @return void
     */
    static public function getWebToken(string $username_protected)
    {
        try {
            $jwt = DB::select(
                "CALL GetStreamJwt("
                . (string) Auth::id()
                . ",'"
                . (string) $username_protected
                . "');"
            );
            if (count($jwt))
                /* Success */
                return json_encode([
                    'result'    => true,
                    "webtoken"  => $jwt
                ]);
            else
                /* Fail */
                return json_encode([
                    'result'    => false,
                    'msg'       => 'You are not a guardian of this user'
                ]);
        } catch (QueryException $e) {
            return json_encode($e);
        }
    }



    /**
     * Get Stream of a protected user
     *
     * @param  mixed $uid_protected
     * @return void
     */
    static public function getStream(string $uid_protected)
    {
        try {
            $stream = Stream::where('uid', '=', $uid_protected)
                        -> get();

            /* Fail */
            if (empty($stream))
                return json_encode([
                    'result'    => false,
                    'msg'       => 'Stream is offline'
                ]);
            /* Success */
            return json_encode([
                'result'    => true,
                'stream'    => $stream
            ]);
        } catch (QueryException $e) {
            return json_encode($e);
        }
    }
}
