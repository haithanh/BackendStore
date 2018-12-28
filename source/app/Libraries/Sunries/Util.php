<?php

namespace App\Libraries\Sunries;


use App\Games;
use App\User;

class Util
{

    public static function getIp()
    {
        $ipaddress = '';
        if (isset($_SERVER['HTTP_CLIENT_IP']))
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        else if (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        else if (isset($_SERVER['HTTP_X_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        else if (isset($_SERVER['HTTP_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        else if (isset($_SERVER['HTTP_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        else if (isset($_SERVER['REMOTE_ADDR']))
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        else
            $ipaddress = '';
        return $ipaddress;
    }

    public static function createResponse($http_code = ERROR_HTTP_SERVER_ERROR, $data = array(), $message = '')
    {
        $oRequest   = app('request');
        $iRequestId = $oRequest->get("request_id");
        $sMessage   = $message;
        if ($http_code > 0)
        {
            $http_code = MSG_SUCCESS;
        }
        if (empty($sMessage))
        {
            $sMessage = Messages::get($http_code);
        }

        if ($iRequestId)
        {
            return array(
                "code"       => $http_code,
                "message"    => $sMessage,
                "data"       => $data,
                "request_id" => $iRequestId
            );
        }

        return array(
            "code"    => $http_code,
            "message" => $sMessage,
            "data"    => $data
        );

    }

    public static function generateRandomString($length = 15, $iType = 0)
    {
        $token        = "";
        $codeAlphabet = "0123456789";
        if ($iType != 1)
        {
            //Only Number
            $codeAlphabet .= "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
            $codeAlphabet .= "abcdefghijklmnopqrstuvwxyz";
        }
        $max = strlen($codeAlphabet); // edited

        for ($i = 0; $i < $length; $i++)
        {
            $token .= $codeAlphabet[random_int(0, $max - 1)];
        }

        return $token;
    }

    public static function getErrorMessagesFromValidate($oValidate, $sType = "string", $sGlue = "\n")
    {
        $aMessage = array();
        foreach ($oValidate->getMessages() as $aErrors)
        {
            $aMessage[] = implode($sGlue, $aErrors);
        }
        if ($sType == "string")
        {
            return implode($sGlue, $aMessage);
        }
        return $aMessage;
    }

    public static function parsePaymentToken($sToken, $isCheckTime = true)
    {
        $aToken = json_decode(Encrypt::aes256Decrypt($sToken, ENCRYPT_PASSWORD, ENCRYPT_IV), true);
        if (empty($aToken))
        {
            return __("Parse token fail");
        }
        $iGame = $aToken["game_id"];
        $sKey  = $aToken["token"];

        $oGame     = Games::find($iGame);
        $oUser     = array();
        $sGameInfo = "";
        if (empty($oGame))
        {
            return __("Game not found");
        }

        $sClassGame = 'App\\Libraries\\Sunries\\Game\\' . $oGame->class;
        /**
         * @var MainGameClass $oClassGame
         */


        if (!class_exists($sClassGame))
        {
            return __("Game class not found");
        }
        $aGameData = json_decode(Encrypt::aes256Decrypt($sKey, $oGame->password, $oGame->IV), true);
        if (!$oGame->party_payment)
        {
            if (!isset($aGameData["user_id"]) || empty($aGameData["user_id"]))
            {
                return __("User is required");
            }
            $oUser = User::find($aGameData["user_id"]);

            if (empty($oUser))
            {
                return __("User not found");
            }
            if ($isCheckTime)
            {
                if ((time() - $aGameData["time"]) > EXPIRED_PAYMENT_TOKEN)
                {
                    return __("Token expired");
                }
            }

        }
        else
        {
            $sGameInfo = $aGameData['information'];
        }
        return array(
            'oGame'     => $oGame,
            'oUser'     => $oUser,
            'sGameInfo' => $sGameInfo
        );
    }
}