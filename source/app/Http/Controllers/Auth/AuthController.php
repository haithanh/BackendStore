<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\ApiController;
use App\Libraries\Sunries\Encrypt;
use App\Libraries\Sunries\Util;
use Illuminate\Http\Request;
use JWTAuth;
use JWTAuthException;

class AuthController extends ApiController
{

    public function login(Request $request)
    {

        // Xác thực app request
        $header          = $request->header('authorization');
        $checkAppRequest = 'Basic ' . md5(env('API_PRIVATE_USER') . env('API_PRIVATE_PASSWORD'));
        if (!isset($header) || $header != $checkAppRequest)
        {
            return response()->json(Util::createResponse(MSG_ERROR_AUTHEN), HTTP_ERROR_AUTHEN);
        }
        // End Xác thực app request
        $emailPassword    = $request->only('email', 'password');
        $usernamePassword = $request->only('username', 'password');
        try
        {
            if (!$token = JWTAuth::attempt($emailPassword))
            {
                if (!$token = JWTAuth::attempt($usernamePassword))
                {
                    return response()->json(Util::createResponse(MSG_ERROR_LOGIN), HTTP_ERROR_VALIDATION);
                }
            }
        }
        catch (JWTException $e)
        {
            return response()->json(Util::createResponse(MSG_ERROR_TOKEN_CREATE), HTTP_ERROR_SERVER);
        }

        $user          = $request->user()->toArray();
        $user["roles"] = $request->user()->getRolesDetail();

        if ($request->user()->status != 1)
        {
            return response()->json(Util::createResponse(MSG_ERROR_USER_DISABLED), HTTP_ERROR_VALIDATION);
        }

        $aGmToolData = array(
            "AccountID" => $user["username"],
            "Time"      => time()
        );

        return response()->json(Util::createResponse(MSG_SUCCESS, compact("token", "user")));
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

            return response()->json(Util::createResponse(MSG_ERROR_PARAMS, $aResponse), HTTP_ERROR_VALIDATION);

        }

        if ($aData["re_pass"] != $aData["new_pass"])
        {
            return response()->json(Util::createResponse(MSG_ERROR_RETYPE_PASSWORD, $aResponse), HTTP_ERROR_VALIDATION);
        }
        if (!\Hash::check($aData["old_pass"], $request->user()->password))
        {
            return response()->json(Util::createResponse(MSG_ERROR_OLD_PASSWORD, $aResponse), HTTP_ERROR_VALIDATION);
        }
        $request->user()->password = \Hash::make($aData["new_pass"]);
        $request->user()->save();

        return response()->json(Util::createResponse(MSG_SUCCESS_UPDATE));
    }

    public function account(Request $request)
    {
        $sAddress  = $request->get('address');
        $sPhone    = $request->get('phone');
        $sFullName = $request->get('full_name');
        $aResponse = array();
        $oUser     = $request->user();
        if (empty($oUser))
        {
            return response()->json(Util::createResponse(MSG_ERROR_USER_NOT_FOUND, $aResponse), HTTP_ERROR_VALIDATION);
        }
        $aInformation              = $oUser->information;
        $aInformation['address']   = $sAddress;
        $aInformation['phone']     = $sPhone;
        $aInformation['full_name'] = $sFullName;

        $oUser->information = $aInformation;
        $oUser->save();

        return response()->json(Util::createResponse(MSG_SUCCESS_UPDATE));
    }
}
