<?php

namespace App\Http\Middleware;

use App\Games;
use App\Libraries\Sunries\Encrypt;
use App\Libraries\Sunries\Util;
use Closure;
use Exception;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use JWTAuth;

class CheckIP
{
	private $aAllowIP = array(
		"::1",
		"127.0.0.1",
		"localhost",
		"123.31.24.16",
		"192.168.1.16",
		'172.19.0.1',
		"115.78.5.187"
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
		//if (!in_array($request->ip(), $this->aAllowIP))
		//{
		//	return response()->json(Util::createResponse(HTTP_ERROR_AUTHEN, __("Not allow IP: " . $request->ip())));
		//}

		return $next($request);
	}
}
