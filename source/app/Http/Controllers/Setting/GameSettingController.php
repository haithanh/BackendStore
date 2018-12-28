<?php

namespace App\Http\Controllers\Setting;

use App\Http\Controllers\ApiController;
use App\Libraries\Sunries\Game\GameClass\MainGameClass;
use App\Libraries\Sunries\Util;
use Illuminate\Http\Request;
use JWTAuth;

class GameSettingController extends ApiController
{

    public function getGoogleSetting(Request $request, $sGameClass)
    {
        $sClassGame = 'App\\Libraries\\Sunries\\Game\\' . $sGameClass;
        /**
         * @var MainGameClass $oClassGame
         */
        $oClassGame = new $sClassGame();
        $aPackages  = $oClassGame->getGoogleSetting();
        return response()->json(Util::createResponse(MSG_SUCCESS, $aPackages));
    }
}
