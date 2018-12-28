<?php

namespace App\Http\Controllers\User;

use App\Games;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use App\Libraries\Sunries\Encrypt;
use App\Libraries\Sunries\Game\GameClass\MainGameClass;
use App\Libraries\Sunries\Util;
use App\Server;
use App\User;
use App\UserGame;
use Facebook\Exceptions\FacebookResponseException;
use Facebook\Exceptions\FacebookSDKException;
use Facebook\Facebook;
use Illuminate\Http\Request;
use JWTAuth;
use JWTAuthException;

class AuthController extends ApiController
{
    public function login(Request $request)
    {
        /**
         * @var Games $oGame
         */
        // Xác thực app request
        $header          = $request->header('authorization');
        $checkAppRequest = 'Basic ' . md5(env('API_PRIVATE_FRONT_USER') . env('API_PRIVATE_FRONT_PASSWORD'));
        if (!isset($header) || $header != $checkAppRequest)
        {
            return response()->json(Util::createResponse(MSG_ERROR_AUTHEN));
        }
        // End Xác thực app request

        $sFacebookToken     = $request->get("facebook_token", null);
        $sFacebookSignature = $request->get("facebook_signature", null);
        $email              = $request->get("email");
        $username           = $request->get("username");
        $emailPassword      = $request->only('email', 'password', 'game_id');
        $usernamePassword   = $request->only('username', 'password', 'game_id');
        $oGame              = $request->attributes->get("oGame");
        $sChannel           = $request->get("ChannelID");
        $sPlatform          = $request->get("PlatformID");

        if (empty($oGame))
        {
            return response()->json(Util::createResponse(MSG_ERROR_GAME_NOT_FOUND));
        }
        $sClassGame = 'App\\Libraries\\Sunries\\Game\\' . $oGame->class;
        /**
         * @var MainGameClass $oClassGame
         */
        $oClassGame = new $sClassGame($request);

        if (!empty($sFacebookSignature))
        {
            $aEmail = $oClassGame->loginFacebookSignature($sFacebookSignature);
            if (!is_array($aEmail))
            {
                return $aEmail;
            }
            try
            {
                $aEmail['game_id'] = $oGame->id;
                if (!$token = JWTAuth::attempt($aEmail))
                {
                    return response()->json(Util::createResponse(MSG_ERROR_LOGIN));
                }
            }
            catch (JWTException $e)
            {
                return response()->json(Util::createResponse(MSG_ERROR_TOKEN_CREATE));
            }
        }
        else if (!empty($sFacebookToken))
        {
            $aEmail = $oClassGame->loginFacebook($sFacebookToken);
            if (!is_array($aEmail))
            {
                return $aEmail;
            }
            try
            {
                $aEmail['game_id'] = $oGame->id;
                if (!$token = JWTAuth::attempt($aEmail))
                {
                    return response()->json(Util::createResponse(MSG_ERROR_LOGIN));
                }
            }
            catch (JWTException $e)
            {
                return response()->json(Util::createResponse(MSG_ERROR_TOKEN_CREATE));
            }
        }
        else
        {
            try
            {
                $token = false;
                if (!empty($email))
                {
                    $token = JWTAuth::attempt($emailPassword);
                }
                if (!empty($username) && !$token)
                {
                    $token = JWTAuth::attempt($usernamePassword);
                }
            }
            catch (JWTException $e)
            {
                return response()->json(Util::createResponse(MSG_ERROR_TOKEN_CREATE));
            }
        }
        /**
         * @var User $oUser
         */
        $oUser = $request->user();
        if (!empty($oUser))
        {
            $oUser->last_login = date("Y-m-d H:i:s");
            $aInformation      = $oUser->information;
            if (!is_array($aInformation))
            {
                $aInformation = json_decode($aInformation, true);
            }

            if (!empty($sChannel) && (!isset($aInformation["channel"]) || (isset($aInformation["channel"]) && empty($aInformation["channel"]))))
            {
                $aInformation["channel"] = strtolower(trim($sChannel));
            }
            if (!empty($sPlatform) && (!isset($aInformation["platform"]) || (isset($aInformation["platform"]) && empty($aInformation["platform"]))))
            {
                $aInformation["platform"] = strtolower(trim($sPlatform));
            }
            $oUser->information = $aInformation;
            $oUser->save();
            $user = $oUser->toArray();
            if ($oUser->status != USER_STATUS_ACTIVE)
            {
                return response()->json(Util::createResponse(MSG_ERROR_USER_DISABLED));
            }
            $oClassGame->moreLoginData($user);
            return response()->json(Util::createResponse(MSG_SUCCESS, compact("token", "user")));
        }
        else
        {
            return response()->json(Util::createResponse(MSG_ERROR_LOGIN));
        }

    }

    public function changePassword(Request $request)
    {
        $aData     = $request->all();
        $aResponse = array();
        $aRules    = array(
            "new_pass" => "required|min:5",
            "old_pass" => "required|min:5",
            "re_pass"  => "required|min:5"
        );
        $validator = \Validator::make($aData, $aRules);
        if ($validator->fails())
        {
            $aResponse["errors"] = $validator->errors();

            return response()->json(Util::createResponse(MSG_ERROR_PARAMS, $aResponse));

        }

        if ($aData["re_pass"] != $aData["new_pass"])
        {
            return response()->json(Util::createResponse(MSG_ERROR_RETYPE_PASSWORD, $aResponse));
        }
        if (!\Hash::check($aData["old_pass"], $request->user()->password))
        {
            return response()->json(Util::createResponse(MSG_ERROR_OLD_PASSWORD, $aResponse));
        }
        $request->user()->password = \Hash::make($aData["new_pass"]);
        $request->user()->save();

        return response()->json(Util::createResponse(MSG_SUCCESS));
    }

    public function captcha(Request $request)
    {
        $captcha = substr(md5(time()), 0, 5);
        $im      = @imagecreate(110, 30);
        $white   = imagecolorallocate($im, 244, 255, 255);
        $red     = imagecolorallocate($im, 255, 255, 255);
        $black   = imagecolorallocate($im, 0, 0, 0);
        $size    = $captcha;
        $text    = "$size";
        $font    = ASSETS_DIR . "/fonts/DeliusSwashCaps-Regular.ttf";
        imagettftext($im, 20, 0, 25, 20, $red, $font, $text);
        imagettftext($im, 20, 0, 25, 20, $black, $font, $text);
        $sFile = ASSETS_DIR . "/captcha/" . time() . ".png";
        imagepng($im, $sFile);
        imagedestroy($im);
        $img = @file_get_contents($sFile);
        @unlink($sFile);
        $key    = md5($captcha . ENCRYPT_PASSWORD);
        $base64 = 'data:image/png;base64,' . base64_encode($img);

        return response()->json(Util::createResponse(MSG_SUCCESS, array(
            "key"   => $key,
            "image" => $base64,
        )));
    }

    public function checkGameToken(Request $request)
    {
        $sGameToken = $request->get("token");
        $aToken     = json_decode(Encrypt::aes256Decrypt($sGameToken, ENCRYPT_PASSWORD, ENCRYPT_IV), true);
        //print_r($aToken);
        if (!isset($aToken["Time"]) || ((time() - $aToken["Time"]) >= DEFAULT_TTL))
        {
            return response()->json(Util::createResponse(MSG_ERROR_TOKEN_EXPIRED));
        }
        $aToken["Password"] = md5($aToken["Account"] . ENCRYPT_PASSWORD);
        return response()->json(Util::createResponse(MSG_SUCCESS, $aToken));
    }
}