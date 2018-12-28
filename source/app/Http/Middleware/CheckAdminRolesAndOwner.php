<?php

namespace App\Http\Middleware;

use App\Libraries\Sunries\Util;
use Closure;
use Exception;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use JWTAuth;

class CheckAdminRolesAndOwner
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure                 $next
     *
     * @return mixed
     */

    public function handle($request, Closure $next, $sPermissions = null)
    {
        if (isset($request->route()->parameters['id']))
        {
            $id = $request->route()->parameters['id'];
        }
        if (empty($request->user()))
        {
            return response()->json(Util::createResponse(MSG_ERROR_PERMISSION));
        }
        if (empty($id) || $request->user()->id != $id)
        {
            $aPermissions = array();
            if (!empty($sPermissions))
            {
                $aPermissions = explode("|", $sPermissions);
            }
            $iGameId = $request->get("game_id", ALL_GAME_ID);
            if (!$request->user()->hasRoles($aPermissions, $iGameId))
            {
                return response()->json(Util::createResponse(MSG_ERROR_PERMISSION));
            }
        }

        return $next($request);
    }
}
