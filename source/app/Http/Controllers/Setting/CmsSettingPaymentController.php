<?php

namespace App\Http\Controllers\Setting;

use App\Games;
use App\Http\Controllers\ApiController;
use App\Libraries\Sunries\Util;
use App\Setting;
use Illuminate\Http\Request;

class CmsSettingPaymentController extends ApiController
{
    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     *
     */
    public function settingCardPaymentGate(Request $request)
    {
        $oCardPaymentGate = Setting::where("key", "=", SETTING_CARD_PAYMENT_GATE)->first();
        $oGames           = Games::all();
        if (empty($oCardPaymentGate))
        {
            $oCardPaymentGate        = new Setting();
            $oCardPaymentGate->key   = SETTING_CARD_PAYMENT_GATE;
            $oCardPaymentGate->value = json_encode(array());
            $oCardPaymentGate->save();
        }
        $aCardPaymentGate = array();
        if (!empty($oCardPaymentGate))
        {
            $aCardPaymentGate = @json_decode($oCardPaymentGate->value, true);
        }
        foreach ($oGames as $game)
        {
            $sKey = "game_" . $game->id;
            if (!isset($aCardPaymentGate[$sKey]))
            {
                $aCardPaymentGate[$sKey] = array();
            }
            foreach (PAYMENT_CARDS as $iTelco => $sTelcoName)
            {
                $sKeyTelco = "telco_" . $iTelco;
                if (!isset($aCardPaymentGate[$sKey][$sKeyTelco]))
                {
                    $aCardPaymentGate[$sKey][$sKeyTelco] = array();
                }
                foreach (PAYMENT_CARDS_VALUE as $iCardValue)
                {
                    $sKeyValue = "value_" . $iCardValue;
                    if (!isset($aCardPaymentGate[$sKey][$sKeyTelco][$sKeyValue]) || empty($aCardPaymentGate[$sKey][$sKeyTelco][$sKeyValue]))
                    {
                        $aCardPaymentGate[$sKey][$sKeyTelco][$sKeyValue] = 0;
                    }
                }
            }
        }

        if ($request->isMethod('post'))
        {
            $aPost = $request->get("cards");
            if (!empty($aPost))
            {
                foreach ($aPost as $sKey => $aTelco)
                {
                    foreach ($aTelco as $sKeyTelco => $aValues)
                    {
                        foreach ($aValues as $sKeyValue => $iPaymentGate)
                        {
                            $aCardPaymentGate[$sKey][$sKeyTelco][$sKeyValue] = $iPaymentGate;
                        }
                    }
                }
                $oCardPaymentGate->value = json_encode($aCardPaymentGate);
                $oCardPaymentGate->save();
            }
        }
        return response()->json(Util::createResponse(MSG_SUCCESS, $aCardPaymentGate));
    }

    public function settingCardPromotion(Request $request)
    {
        $oCardPaymentPromotion = Setting::where("key", "=", SETTING_CARD_PAYMENT_PROMOTION)->first();
        $oGames                = Games::all();
        if (empty($oCardPaymentPromotion))
        {
            $oCardPaymentPromotion        = new Setting();
            $oCardPaymentPromotion->key   = SETTING_CARD_PAYMENT_PROMOTION;
            $oCardPaymentPromotion->value = json_encode(array());
            $oCardPaymentPromotion->save();
        }

        $aCardPaymentPromotion = array();
        if (!empty($oCardPaymentPromotion))
        {
            $aCardPaymentPromotion = @json_decode($oCardPaymentPromotion->value, true);
        }

        foreach ($oGames as $oGame)
        {
            $sKeyGame = "game_" . $oGame->id;
            if (!isset($aCardPaymentPromotion[$sKeyGame]))
            {
                $aCardPaymentPromotion[$sKeyGame] = array();
            }
            if (!isset($aCardPaymentPromotion[$sKeyGame]["start"]))
            {
                $aCardPaymentPromotion[$sKeyGame]["start"] = "";
            }
            if (!isset($aCardPaymentPromotion[$sKeyGame]["end"]))
            {
                $aCardPaymentPromotion[$sKeyGame]["end"] = "";
            }
            if (!isset($aCardPaymentPromotion[$sKeyGame]["cards"]))
            {
                $aCardPaymentPromotion[$sKeyGame]["cards"] = array();
            }
            foreach (PAYMENT_CARDS as $iTelco => $sTelcoName)
            {
                foreach (PAYMENT_CARDS_VALUE as $iCardValue)
                {
                    if (!isset($aCardPaymentPromotion[$sKeyGame]['cards'][$iTelco]))
                    {
                        $aCardPaymentPromotion[$sKeyGame]['cards'][$iTelco] = array();
                    }
                    if (!isset($aCardPaymentPromotion[$sKeyGame]['cards'][$iTelco][$iCardValue]) || empty($aCardPaymentPromotion[$sKeyGame]['cards'][$iTelco][$iCardValue]))
                    {
                        $aCardPaymentPromotion[$sKeyGame]['cards'][$iTelco][$iCardValue] = array(
                            "from" => 0,
                            "to"   => 0
                        );
                    }
                }
            }
        }


        if ($request->isMethod('post'))
        {
            $aPosts = $request->get("cards");
            if (!empty($aPosts))
            {
                foreach ($aPosts as $sKeyGame => $aPost)
                {
                    if (isset($aCardPaymentPromotion[$sKeyGame]))
                    {
                        if (isset($aPost['start']))
                        {
                            $aCardPaymentPromotion[$sKeyGame]["start"] = $aPost['start'];
                        }
                        if (isset($aPost['end']))
                        {
                            $aCardPaymentPromotion[$sKeyGame]["end"] = $aPost['end'];
                        }
                        if (isset($aPost['cards']))
                        {
                            foreach (PAYMENT_CARDS as $iTelco => $sTelcoName)
                            {
                                foreach (PAYMENT_CARDS_VALUE as $iCardValue)
                                {
                                    if (isset($aPost['cards'][$iTelco]) && isset($aPost['cards'][$iTelco][$iCardValue]))
                                    {
                                        if (isset($aPost['cards'][$iTelco][$iCardValue]['from']))
                                        {
                                            $aCardPaymentPromotion[$sKeyGame]['cards'][$iTelco][$iCardValue]['from'] = $aPost['cards'][$iTelco][$iCardValue]['from'];
                                        }
                                        if (isset($aPost['cards'][$iTelco][$iCardValue]['to']))
                                        {
                                            $aCardPaymentPromotion[$sKeyGame]['cards'][$iTelco][$iCardValue]['to'] = $aPost['cards'][$iTelco][$iCardValue]['to'];
                                        }

                                    }
                                }
                            }
                        }
                    }
                }
                $oCardPaymentPromotion->value = json_encode($aCardPaymentPromotion);
                $oCardPaymentPromotion->save();
            }
        }
        return response()->json(Util::createResponse(MSG_SUCCESS, $aCardPaymentPromotion));
    }

    public function settingReward(Request $request)
    {
        $oReward = Setting::where("key", "=", SETTING_REWARDS_AUTO)->first();
        $oGames  = Games::all();
        if (empty($oReward))
        {
            $oReward        = new Setting();
            $oReward->key   = SETTING_REWARDS_AUTO;
            $oReward->value = json_encode(array());
            $oReward->save();
        }
        $aRewards = array();
        if (!empty($oReward))
        {
            $aRewards = @json_decode($oReward->value, true);
        }
        foreach ($oGames as $oGame)
        {
            if (!isset($aRewards['game_' . $oGame->id]))
            {
                $aRewards['game_' . $oGame->id] = 0;
            }
        }

        if ($request->isMethod('post'))
        {
            $aPost = $request->get("game_rewards");
            if (!empty($aPost))
            {
                foreach ($aPost as $sGame => $iAuto)
                {
                    $aRewards[$sGame] = $iAuto;
                }
                $oReward->value = json_encode($aRewards);
                $oReward->save();
            }
        }
        return response()->json(Util::createResponse(MSG_SUCCESS, $aRewards));
    }

    public function settingRewardLimit(Request $request)
    {
        $oReward = Setting::where("key", "=", SETTING_REWARDS_LIMIT)->first();
        $oGames  = Games::all();
        if (empty($oReward))
        {
            $oReward        = new Setting();
            $oReward->key   = SETTING_REWARDS_LIMIT;
            $oReward->value = json_encode(array());
            $oReward->save();
        }
        $aRewards = array();
        if (!empty($oReward))
        {
            $aRewards = @json_decode($oReward->value, true);
        }
        foreach ($oGames as $oGame)
        {
            if (!isset($aRewards['game_' . $oGame->id]))
            {
                $aRewards['game_' . $oGame->id] = array(
                    "total_vnd_limit"   => 0,
                    "user_vnd_limit"    => 0,
                    "user_number_limit" => 3
                );
            }
        }

        if ($request->isMethod('post'))
        {
            $aPost = $request->get("game_rewards");
            if (!empty($aPost))
            {
                foreach ($aPost as $sKey => $anyValue)
                {
                    foreach ($anyValue as $sKeyValue => $value)
                    {
                        $aRewards[$sKey][$sKeyValue] = $value;
                    }
                }
                $oReward->value = json_encode($aRewards);
                $oReward->save();
            }
        }
        return response()->json(Util::createResponse(MSG_SUCCESS, $aRewards));
    }

    public function settingAgency(Request $request)
    {
        $oAgency       = Setting::where("key", "=", SETTING_AGENCY)->first();
        $oGames        = Games::all();
        $aDefault      = array(
            "game_name"          => "",
            "agency_on_off"      => 0,
            "user_to_agency_per" => 0,
            "agency_to_user_per" => 0,
            "user_to_agency_min" => 0,
            "agency_to_user_min" => 0,
            "user_to_agency_max" => 0,
            "agency_to_user_max" => 0
        );
        $aDefaultGames = array();
        foreach ($oGames as $oGame)
        {
            $aDefault["game_name"]               = $oGame->name;
            $aDefaultGames["game_" . $oGame->id] = $aDefault;
        }


        if (empty($oAgency))
        {
            $oAgency        = new Setting();
            $oAgency->key   = SETTING_AGENCY;
            $oAgency->value = json_encode($aDefaultGames);
            $oAgency->save();
        }
        $aAgencyValues = $aDefaultGames;
        if (!empty($oAgency))
        {
            $aAgencyValues = @json_decode($oAgency->value, true);
        }

        if ($request->isMethod('post'))
        {
            $aPost = $request->get("agency_setting");
            if (!empty($aPost))
            {
                foreach ($aPost as $sKey => $anyValue)
                {

                    foreach ($anyValue as $sKeyValue => $value)
                    {
                        if ($sKeyValue != "game_name")
                        {
                            $aAgencyValues[$sKey][$sKeyValue] = $value;
                        }
                    }
                }
            }
            $oAgency->value = json_encode($aAgencyValues);
            $oAgency->save();
        }
        return response()->json(Util::createResponse(MSG_SUCCESS, $aAgencyValues));
    }

    public function settingFirstCard(Request $request)
    {
        $oFirstCard    = Setting::where("key", "=", SETTING_PAYMENT_FIRST_CARD)->first();
        $oGames        = Games::all();
        $aDefault      = array(
            "game_name"               => "",
            "first_card_percent"      => 0,
            "first_card_price"        => 0,
            "second_card_percent_min" => 0,
            "second_card_percent_max" => 0,
            "date_start"              => date("Y-m-d H:i:s"),
            "date_end"                => date("Y-m-d H:i:s")
        );
        $aDefaultGames = array();
        foreach ($oGames as $oGame)
        {
            $aDefault["game_name"]               = $oGame->name;
            $aDefaultGames["game_" . $oGame->id] = $aDefault;
        }


        if (empty($oFirstCard))
        {
            $oFirstCard        = new Setting();
            $oFirstCard->key   = SETTING_PAYMENT_FIRST_CARD;
            $oFirstCard->value = json_encode($aDefaultGames);
            $oFirstCard->save();
        }
        $aValues = $aDefaultGames;
        if (!empty($oFirstCard))
        {
            $aValues = @json_decode($oFirstCard->value, true);
        }

        if ($request->isMethod('post'))
        {
            $aPost = $request->get("setting_items");
            if (!empty($aPost))
            {
                foreach ($aPost as $sKey => $anyValue)
                {

                    foreach ($anyValue as $sKeyValue => $value)
                    {
                        if ($sKeyValue != "game_name")
                        {
                            $aValues[$sKey][$sKeyValue] = $value;
                        }
                    }
                }
            }
            $oFirstCard->value = json_encode($aValues);
            $oFirstCard->save();
        }
        return response()->json(Util::createResponse(MSG_SUCCESS, $aValues));
    }
}
