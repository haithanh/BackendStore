<?php

namespace App\Http\Middleware;

use App\Games;
use App\Libraries\Sunries\Util;
use Closure;

class CheckGameId
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

		$iGameId = $request->get("game_id");
		if (empty($iGameId))
		{
			return response()->json(Util::createResponse(MSG_ERROR_GAME_NOT_FOUND));
		}
		$oGame = Games::find($iGameId);
		if (empty($oGame))
		{
			return response()->json(Util::createResponse(MSG_ERROR_GAME_NOT_FOUND));
		}
		$request->attributes->set("oGame", $oGame);

		return $next($request);
	}
}
