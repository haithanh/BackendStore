<?php

namespace App\Http\Controllers\Setting;

use App\Http\Controllers\ApiController;
use App\Libraries\Sunries\Util;
use Illuminate\Http\Request;
use JWTAuth;

class OtherSettingController extends ApiController
{

    public function getDefaultSetting(Request $request)
    {
        $aSettings = array(
            "card_telcos" => PAYMENT_CARDS,
            "card_values" => PAYMENT_CARDS_VALUE
        );
        return response()->json(Util::createResponse(MSG_SUCCESS, $aSettings));
    }
}
