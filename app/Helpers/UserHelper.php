<?php
/**
 * Created by PhpStorm.
 * User: yannis
 * Date: 06/05/2019
 * Time: 16:08
 */

namespace App\Helpers;

use Tymon\JWTAuth\Facades\JWTAuth;

class UserHelper
{

    /**
     * Get Current Loged User
     * @param $token
     * @return mixed
     */
    public static function getJwtUser()
    {
        $token = JWTAuth::getToken();
        $user = JWTAuth::toUser($token);
        return ($user);
    }
}