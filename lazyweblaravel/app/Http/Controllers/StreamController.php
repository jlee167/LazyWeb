<?php

namespace App\Http\Controllers;

use APP\Models\Stream;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class StreamController extends Controller
{
    static public function getWebToken($username)
    {
        try {
            $jwt = DB::select(
                "CALL GetJwtWithUname("
                . (string) Auth::id()
                . ",'"
                . (string) $username
                . "');"
            );
            if (count($jwt))
                return json_encode(["webtoken" => $jwt]);
            else
                return "You are not a guardian of this user";
        } catch (QueryException $e) {
            return json_encode($e);
        }
    }
}
