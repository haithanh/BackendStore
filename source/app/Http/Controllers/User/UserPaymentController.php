<?php

namespace App\Http\Controllers\User;

use App\Games;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use App\InternalLog;
use App\Libraries\Sunries\Encrypt;
use App\Libraries\Sunries\Util;
use App\Transaction;
use App\User;
use App\UserCoinsLog;
use App\UserLog;
use Illuminate\Http\Request;

class UserPaymentController extends ApiController
{
    /**
     * @param Request $request
     * @param int     $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function coins(Request $request)
    {
        /**
         * @var Games $oGame
         */
        try
        {
            $iCoins      = $request->get("coins");
            $oGame       = $request->attributes->get("oGame");
            $reason      = $request->get("reason");
            $information = $request->get("information");
            $id          = $request->user()->id;
            $iServerId   = $request->get("server_id");

            if (is_string($information))
            {
                $information = json_decode($information, true);
            }
            if (empty($id))
            {
                return response()->json(Util::createResponse(MSG_ERROR_PARAMS));
            }

            if (empty($iCoins) || !is_numeric($iCoins) || $iCoins <= 0)
            {
                return response()->json(Util::createResponse(MSG_ERROR_USER_COINS));
            }

            $oUser = User::find($id);
            if (empty($oUser))
            {
                return response()->json(Util::createResponse(MSG_ERROR_USER_NOT_FOUND));
            }

            if ($oUser->coins < $iCoins)
            {
                return response()->json(Util::createResponse(MSG_ERROR_USER_COINS_GREATER));
            }

            $iNewCoin                  = $oUser->coins - $iCoins;
            $information["old_coin"]   = $oUser->coins;
            $information["minus_coin"] = $iCoins;
            $information["new_coin"]   = $iNewCoin;
            $oUser->coins              = $iNewCoin;
            $bResult                   = $oUser->save();
            if ($bResult)
            {
                UserLog::create(array(
                    "user_id"       => $request->user()->id,
                    "game_id"       => $oGame->id,
                    "reason"        => $reason,
                    "information"   => $information,
                    "server_id"     => $iServerId,
                    "server_reason" => "Game Minus coins"
                ));
                UserCoinsLog::saveLog($request->user()->id, $oGame->id, (-$iCoins), $iNewCoin, "Game Minus coins");
                return response()->json(Util::createResponse(MSG_SUCCESS_UPDATE, $oUser->toArray()));
            }

            return response()->json(Util::createResponse(MSG_ERROR_ACTION));

        }
        catch (\Exception $e)
        {
            return response()->json(Util::createResponse(MSG_ERROR_ACTION, array(), $e->getMessage()));
        }
    }

    /**
     * Internal
     *
     * @param Request $request
     */
    public function getCoin(Request $request)
    {
        $aData = $request->attributes->get("data");
        if (!isset($aData["uid"]) || empty($aData["uid"]))
        {
            return response()->json(Util::createResponse(MSG_ERROR_PARAMS));
        }
        $oUser = User::where("uid", "=", $aData["uid"])->first();
        if (empty($oUser))
        {
            return response()->json(Util::createResponse(MSG_ERROR_USER_NOT_FOUND));
        }

        return response()->json(Util::createResponse(MSG_SUCCESS, array("coins" => $oUser->coins)));

    }

    /**
     *
     * @param Request $request
     */
    public function changeCoins(Request $request)
    {
        $aData     = $request->attributes->get("data");
        $oGame     = $request->attributes->get("oGame");
        $oSubGame  = $request->attributes->get("oSubGame");
        $aRules    = array(
            'uid'   => array(
                'required'
            ),
            'coins' => array(
                'required',
                'numeric'
            )
        );
        $validator = \Validator::make($aData, $aRules);
        if ($validator->fails())
        {
            return response()->json(Util::createResponse(MSG_ERROR_PARAMS, array(
                "errors" => $validator->errors()
            )));
        }
        $oUser = User::where("uid", "=", $aData["uid"])->first();
        if (empty($oUser))
        {
            return response()->json(Util::createResponse(MSG_ERROR_USER_NOT_FOUND));
        }
        $iOldCoin  = $oUser->coins;
        $iNewCoins = $oUser->coins + $aData["coins"];
        if ($iNewCoins < 0)
        {
            return response()->json(Util::createResponse(MSG_ERROR_USER_COINS));
        }
        $oUser->coins = $iNewCoins;
        $oUser->save();
        InternalLog::saveLog($oGame->id, $oUser->id, INTERNAL_LOG_TYPE_CHANGE_COINS, array(
            "coins" => $iOldCoin
        ), array(
            "coins" => $iNewCoins
        ), $oSubGame->id
        );
        UserCoinsLog::saveLog($oUser->id, $oGame->id, $aData["coins"], $iNewCoins, "Internal change coins");
        return response()->json(Util::createResponse(MSG_SUCCESS_UPDATE, array("coins" => $iNewCoins)));

    }

    /**
     *
     * @param Request $request
     */
    public function emptyCoins(Request $request)
    {
        $aData     = $request->attributes->get("data");
        $oGame     = $request->attributes->get("oGame");
        $oSubGame  = $request->attributes->get("oSubGame");
        $aRules    = array(
            'uid' => array(
                'required'
            )
        );
        $validator = \Validator::make($aData, $aRules);
        if ($validator->fails())
        {
            return response()->json(Util::createResponse(MSG_ERROR_PARAMS, array(
                "errors" => $validator->errors()
            )));
        }
        $oUser = User::where("uid", "=", $aData["uid"])->first();
        if (empty($oUser))
        {
            return response()->json(Util::createResponse(MSG_ERROR_USER_NOT_FOUND));
        }
        $iOldCoin     = $oUser->coins;
        $iNewCoins    = 0;
        $oUser->coins = $iNewCoins;
        $oUser->save();
        InternalLog::saveLog($oGame->id, $oUser->id, INTERNAL_LOG_TYPE_EMPTY_COINS, array(
            "coins" => $iOldCoin
        ), array(
            "coins" => $iNewCoins
        ), $oSubGame->id
        );
        UserCoinsLog::saveLog($oUser->id, $oGame->id, (-$iOldCoin), 0, "Internal empty coins");
        return response()->json(Util::createResponse(MSG_SUCCESS_UPDATE, array("coins" => $iOldCoin)));

    }

    public function getUserCharge(Request $request)
    {
        $aData     = $request->attributes->get("data");
        $aRules    = array(
            'uid' => array(
                'required'
            )
        );
        $validator = \Validator::make($aData, $aRules);
        if ($validator->fails())
        {
            return response()->json(Util::createResponse(MSG_ERROR_PARAMS, array(
                "errors" => $validator->errors()
            )));
        }
        $oUser = User::where("uid", "=", $aData["uid"])->first();
        if (empty($oUser))
        {
            return response()->json(Util::createResponse(MSG_ERROR_USER_NOT_FOUND));
        }

        $iTotal = Transaction::getTotalChargeById($oUser->id);

        return response()->json(Util::createResponse(MSG_SUCCESS, array("total" => $iTotal)));
    }


}