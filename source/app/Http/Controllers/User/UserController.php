<?php

namespace App\Http\Controllers\User;

use App\Games;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use App\Libraries\Sunries\Util;
use App\User;
use App\UserGame;
use App\UserLog;
use Hash;
use Illuminate\Http\Request;
use JWTAuth;
use JWTAuthException;

class UserController extends ApiController
{
    public function create(Request $request)
    {
        $aData         = $request->only("username", "email", "password", "information", "display_name", "game_id");
        $userModel     = new User();
        $sCaptchaKey   = $request->get("captcha_key", null);
        $sCaptchaValue = $request->get("captcha_value", null);
        if (empty($sCaptchaKey) || empty($sCaptchaValue))
        {
            return response()->json(Util::createResponse(MSG_ERROR_CAPTCHA));
        }
        else
        {
            $key = md5($sCaptchaValue . ENCRYPT_PASSWORD);
            if ($sCaptchaKey != $key)
            {
                return response()->json(Util::createResponse(MSG_ERROR_CAPTCHA));
            }
        }
        try
        {
            $aData["status"]  = 1;
            $aData["is_test"] = 0;
            if (!isset($aData["email"]) || empty($aData["email"]))
            {
                $aData["email"] = $aData["username"] . "@vosovang.com";
            }
            if (!isset($aData["display_name"]) || empty($aData["display_name"]))
            {
                $aData["display_name"] = $aData["username"] . "_" . Util::generateRandomString();
            }
            $aData["uid"]      = Util::generateRandomString();
            $oCheckDisplayName = User::where("display_name", "=", $aData["display_name"])->first();
            while (!empty($oCheckDisplayName))
            {
                $aData["display_name"] = $aData["username"] . "_" . Util::generateRandomString();
                $oCheckDisplayName     = User::where("display_name", "=", $aData["display_name"])->first();
            }
            $oCheckUID = User::where("uid", "=", $aData["uid"])->first();
            while (!empty($oCheckUID))
            {
                $aData["uid"] = Util::generateRandomString();
                $oCheckUID    = User::where("uid", "=", $aData["uid"])->first();
            }

            $validate = $userModel->validator($aData);

            if ($validate)
            {
                $aDataResponse["errors"] = $validate;

                return response()->json(Util::createResponse(MSG_ERROR_VALIDATION, $aDataResponse, Util::getErrorMessagesFromValidate($validate)));
            }
            $aData["password"] = Hash::make($aData["password"]);

            $userModel->fill($aData);
            $userModel->coins = 0;
            $userModel->save();
            $aResult = $userModel->toArray();

            return response()->json(Util::createResponse(MSG_SUCCESS_CREATE, $aResult));
        }
        catch (\Exception $e)
        {
            return response()->json(Util::createResponse(MSG_ERROR_ACTION, array(), $e->getMessage()));
        }
    }

    /**
     * @param Request $request
     * @param int     $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request)
    {
        try
        {
            $aData = $request->only("email", "information", "display_name");
            unset($aData["coins"]);
            unset($aData["password"]);
            $id    = $request->user()->id;
            $aData = array_filter($aData);
            if (empty($id) || empty($aData))
            {
                return response()->json(Util::createResponse(MSG_ERROR_PARAMS));
            }
            $oUser = User::find($id);

            if (empty($oUser))
            {
                return response()->json(Util::createResponse(MSG_ERROR_USER_NOT_FOUND));
            }
            $oUser->fill($aData);
            $aCheckData = $oUser->toArray();
            $aValidate  = $oUser->validator($aCheckData, $id);

            if ($aValidate)
            {
                $response["errors"] = $aValidate;
                $sMessage           = array();
                foreach ($aValidate->getMessages() as $aErrors)
                {
                    $sMessage[] = implode("\n", $aErrors);
                }

                $sMessage = implode("\n", $sMessage);


                return response()->json(Util::createResponse(MSG_ERROR_VALIDATION, $response, $sMessage));
            }

            $oUser->save();

            return response()->json(Util::createResponse(MSG_SUCCESS_UPDATE, $oUser->toArray()));

        }
        catch (\Exception $e)
        {
            return response()->json(Util::createResponse(MSG_ERROR_ACTION, array(), $e->getMessage()));
        }

    }

    /**
     * @param Request $request
     * @param int     $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function detail(Request $request)
    {
        try
        {
            $id = $request->user()->id;

            $oUser = User::find($id);

            if (empty($oUser))
            {
                return response()->json(Util::createResponse(MSG_ERROR_USER_NOT_FOUND));
            }
            $aUser = $oUser->toArray();

            return response()->json(Util::createResponse(MSG_SUCCESS, $aUser));
        }
        catch (\Exception $e)
        {
            return response()->json(Util::createResponse(MSG_ERROR_ACTION, array(), $e->getMessage()));
        }
    }
}
