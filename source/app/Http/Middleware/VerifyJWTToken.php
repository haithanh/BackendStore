<?php

namespace App\Http\Middleware;

use App\Libraries\Sunries\Util;
use Closure;
use Exception;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use JWTAuth;

class VerifyJWTToken
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
		try
		{
			JWTAuth::parseToken();
			$token   = JWTAuth::getToken();
			$user    = JWTAuth::authenticate();
			$payload = JWTAuth::getPayload();
		}
		catch (JWTException $e)
		{
			if ($e instanceof TokenExpiredException)
			{
				return response()->json(Util::createResponse(MSG_ERROR_TOKEN_EXPIRED), HTTP_ERROR_AUTHEN);
			}
			else if ($e instanceof TokenInvalidException)
			{
				return response()->json(Util::createResponse(MSG_ERROR_TOKEN_INVALID), HTTP_ERROR_AUTHEN);
			}
			else
			{
				return response()->json(Util::createResponse(MSG_ERROR_TOKEN_REQUIRED), HTTP_ERROR_AUTHEN);
			}
		}

		return $next($request);
	}
}
