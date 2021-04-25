<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Routing\Redirector;
use APP\Models\User;

class OauthTokenController extends BaseController
{
    /**
     * getGoogleUser
     *
     * @param  mixed $accessToken
     * @return void
     */
    public static function getGoogleUser($accessToken){

        try {
            $user = [];
            $client = new \Google_Client();
            $client->setClientId('1083086831094-qatr04h8rnthlm9501q2oa45mjkjh4r0.apps.googleusercontent.com');
            $client->setClientSecret('fGLi65s6_vDNunavqdCFrZom');

            if ($accessToken) {
                $payload = $client->verifyIdToken($accessToken);
            }

            if ($payload) {
                $user['uid']                = $payload['sub'];
                $user['email']              = $payload['email'];
                $user['verified']           = $payload['email_verified'];
                $user['name']               = $payload['name'];
                $user['profile_picture']    = $payload['picture'];
                return $user;
            } else {
                // Invalid ID token
                return null;
            }
        } catch (\Exception $e) {
            return "error@!";
        }
    }


    public static function getKakaoUser($accessToken){
        /* Make Rest API Request to Kakao */
        $authorization = 'Authorization: Bearer ' . $accessToken;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer ' . $accessToken));
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

        if (!$result) {
            echo 'No response from Kakao Auth Server \n';
            exit;
        }

        $user = [];
        $user['uid'] = $result["id"];
        $user['name'] = $result["properties"]["nickname"];
        $user['email'] = $result["kakao_account"]["email"];
        $user['profile_picture'] = $result["kakao_account"]["profile"]["thumbnail_image_url"];
        return $user;
    }
}
