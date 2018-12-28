<?php

namespace App\Http\Controllers\Setting;

use App\Games;
use App\Http\Controllers\ApiController;
use App\Libraries\Sunries\Game\GameClass\MainGameClass;
use App\Libraries\Sunries\Util;
use App\Setting;
use Illuminate\Http\Request;
use JWTAuth;

class EventSettingController extends ApiController
{
    public function settingPaymentCode(Request $request)
    {
        $oSettings = Setting::where("key", "=", SETTING_EVENT_PAYMENT_CODE)->first();
        $oGames    = Games::whereStatus(GAME_STATUS_ACTIVE)->get();
        if (empty($oSettings))
        {
            $oSettings        = new Setting();
            $oSettings->key   = SETTING_EVENT_PAYMENT_CODE;
            $oSettings->value = json_encode(array());
            $oSettings->save();
        }
        $aSettings = array();
        if (!empty($oSettings))
        {
            $aSettings = @json_decode($oSettings->value, true);
        }

        foreach ($oGames as $oGame)
        {
            $sKeyGame = "game_" . $oGame->id;
            if (!isset($aSettings[$sKeyGame]))
            {
                $aSettings[$sKeyGame] = array();
            }
            if (!isset($aSettings[$sKeyGame]["start"]))
            {
                $aSettings[$sKeyGame]["start"] = "";
            }
            if (!isset($aSettings[$sKeyGame]["end"]))
            {
                $aSettings[$sKeyGame]["end"] = "";
            }

            foreach (PAYMENT_CARDS_VALUE as $iCardValue)
            {
                $sKeyValue = "value_" . $iCardValue;
                if (!isset($aSettings[$sKeyGame][$sKeyValue]) || empty($aSettings[$sKeyGame][$sKeyValue]))
                {
                    $aSettings[$sKeyGame][$sKeyValue] = 0;
                }
            }
        }

        if ($request->isMethod('post'))
        {
            $aPosts = $request->get("settings");
            if (!empty($aPosts))
            {
                foreach ($aPosts as $sKeyGame => $aPost)
                {
                    if (isset($aSettings[$sKeyGame]))
                    {
                        if (isset($aPost['start']))
                        {
                            $aSettings[$sKeyGame]["start"] = $aPost['start'];
                        }
                        if (isset($aPost['end']))
                        {
                            $aSettings[$sKeyGame]["end"] = $aPost['end'];
                        }
                        foreach (PAYMENT_CARDS_VALUE as $iCardValue)
                        {
                            $sKeyValue = "value_" . $iCardValue;
                            if (isset($aPost[$sKeyValue]))
                            {
                                $aSettings[$sKeyGame][$sKeyValue] = $aPost[$sKeyValue];
                            }
                        }
                    }
                }
                $oSettings->value = json_encode($aSettings);
                $oSettings->save();
            }
        }
        return response()->json(Util::createResponse(MSG_SUCCESS, $aSettings));
    }
}
