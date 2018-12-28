<?php

namespace App\Http\Middleware;

use App\Games;
use App\Libraries\Sunries\Encrypt;
use App\Libraries\Sunries\Util;
use App\SubGame;
use Closure;
use Exception;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use JWTAuth;

class InternalCall
{
    private $aAllowIP = array(
        "::1",
        "127.0.0.1",
        "localhost",
        "123.31.24.16",
        "192.168.1.16"
    );

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure                 $next
     *
     * @return mixed
     */

    public function handle($request, Closure $next)
    {

        $iSubGameId = $request->get("sub_game_id");
        $oSubGame   = SubGame::find($iSubGameId);
        if (empty($oSubGame))
        {
            return response()->json(Util::createResponse(MSG_ERROR_SUBGAME_NOT_FOUND));
        }
        $sData    = $request->get("data");
        $request->attributes->set("oSubGame", $oSubGame);
        $oGame    = $request->attributes->get("oGame");
        $sData    = Encrypt::aes256Decrypt($sData, $oGame->password, $oGame->IV);
        $aData    = json_decode($sData, true);
        if (empty($aData))
        {
            return response()->json(Util::createResponse(MSG_ERROR_PARAMS));
        }
        $request->attributes->set("data", $aData);

        return $next($request);
    }
}
