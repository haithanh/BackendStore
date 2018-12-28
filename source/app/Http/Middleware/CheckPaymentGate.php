<?php

namespace App\Http\Middleware;

use App\Libraries\Sunries\Encrypt;
use App\Libraries\Sunries\Util;
use App\PaymentGate;
use Closure;
use Exception;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use JWTAuth;

class CheckPaymentGate
{
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
        $iPaymentGateId = $request->gate_id;
        $oPaymentGate   = PaymentGate::find($iPaymentGateId);
        if (empty($oPaymentGate))
        {
            return response()->json(Util::createResponse(MSG_ERROR_TOKEN));
        }

        if (!isset($oPaymentGate->information["IV"]) || !isset($oPaymentGate->information["password"]))
        {
            return response()->json(Util::createResponse(MSG_ERROR_GAME_PAYMENT_GATE));
        }

        $sToken = $request->header('authorization');
        $atoken = explode(" ", $sToken);
        if(count($atoken) != 2)
        {
            return response()->json(Util::createResponse(MSG_ERROR_TOKEN_INVALID));
        }

        $sToken = $atoken[1];
        $sToken = Encrypt::aes256Decrypt($sToken,$oPaymentGate->information["password"], $oPaymentGate->information["IV"]);
        $aToken = explode(".",$sToken);
        if(count($aToken) != 2)
        {
            return response()->json(Util::createResponse(MSG_ERROR_TOKEN_PARSE));
        }

        if($aToken[0] != $iPaymentGateId)
        {
            return response()->json(Util::createResponse(MSG_ERROR_GAME_PAYMENT_GATE));
        }

        if((time() - $aToken[1]) > 60)
        {
            return response()->json(Util::createResponse(MSG_ERROR_TOKEN_EXPIRED));
        }

        $request->attributes->set("oPaymentGate",$oPaymentGate);

        return $next($request);
    }
}
