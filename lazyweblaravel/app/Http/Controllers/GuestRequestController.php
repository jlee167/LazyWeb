<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;


class GuestRequestController extends BaseController
{

    private function getServerHeartBeat()
    {
        $resp = (object) array('response' => 'OK');
		$str_json_format = json_encode($resp);
        return $resp;
    }

    public function mainHandler($request_http, $request_user) {
        switch ($request_user) {
            case 'Http Test':
                return getServerHeartBeat();

            default:
                return json_encode((object) array('response' => 'Invalid Request'));
        }
    }

}
