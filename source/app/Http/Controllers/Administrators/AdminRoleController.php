<?php

namespace App\Http\Controllers\Administrators;

use App\UserActionLog;
use App\User;
use App\AdminRoles;
use App\Games;
use App\Http\Controllers\ApiController;
use App\Libraries\Sunries\Util;
use App\Roles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use PhpParser\Builder\Param;

class AdminRoleController extends ApiController
{

	/**
	 * @param Request $request
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function get(Request $request)
	{
		$oAdminRoles = \DB::table('admins_roles')
						  ->select(array(
									   "*"
								   ))
						  ->join('administrators', 'admins_roles.admin_id', '=', 'administrators.id')
						  ->get()
		;
		$oRoles      = Roles::all();
		$oGames      = Games::all();
		$aRoles      = array();
		if (!empty($oRoles) && !empty($oGames))
		{
			$aTempRoles = array();
			if (!empty($oAdminRoles))
			{
				foreach ($oAdminRoles as $oRole)
				{
					$aTempRoles[$oRole->role_id . "_" . $oRole->game_id][] = array(
						"id"       => $oRole->admin_id,
						"username" => $oRole->username
					);
				}
			}
			foreach ($oRoles as $oRole)
			{
				$aGames = array();
				foreach ($oGames as $oGame)
				{
					if (($oRole->name != ROLE_SUPER_ADMIN && $oGame->id == 1) || ($oRole->name == ROLE_SUPER_ADMIN && $oGame->id != 1))
					{
						continue;
					}
					$aGame = array(
						"id"    => $oGame->id,
						"name"  => $oGame->name,
						"users" => array()
					);
					if (isset($aTempRoles[$oRole->id . "_" . $oGame->id]))
					{
						$aGame["users"] = $aTempRoles[$oRole->id . "_" . $oGame->id];
					}
					$aGames[] = $aGame;
				}
				$aRoles[] = array(
					"id"    => $oRole->id,
					"name"  => $oRole->name,
					"games" => $aGames
				);

			}
		}

		return response()->json(Util::createResponse(MSG_SUCCESS, $aRoles));
	}

	/**
	 * @param Request $request
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function update(Request $request)
	{
		$aData  = $request->get("roles", null);
		$aRoles = $aData;
		if (is_string($aData))
		{
			$aRoles = json_decode($aData, true);
		}
		if (empty($aRoles))
		{
			return response()->json(Util::createResponse(MSG_ERROR_PARAMS_ROLE),HTTP_ERROR_VALIDATION);
		}
		$aDataInsert    = array();
		$aAdminIdChange = array();
		$oldData        = AdminRoles::all()->toArray();
		\DB::beginTransaction();
		try
		{
			foreach ($aRoles as $oRole)
			{
				foreach ($oRole["games"] as $oGame)
				{
					foreach ($oGame["users"] as $oAdmin)
					{
						$aAdminIdChange[] = $oAdmin["id"];
						$aDataInsert[]    = array(
							"admin_id" => $oAdmin["id"],
							"game_id"  => $oGame["id"],
							"role_id"  => $oRole["id"]
						);
					}
				}
			}
			$aAdminIdChange = array_unique($aAdminIdChange);
			$oCurrentRoles  = AdminRoles::whereIn("admin_id", $aAdminIdChange);
			$oCurrentRoles->delete();
			AdminRoles::unguard();
			AdminRoles::insert($aDataInsert);
			AdminRoles::reguard();
			UserActionLog::saveLog($request->user()->id, -1, ACTION_LOG_TYPE_ROLE, $oldData, $aDataInsert);
			\DB::commit();
		}
		catch (\Exception $e)
		{
			\DB::rollBack();
		}

		return response()->json(Util::createResponse(MSG_SUCCESS_UPDATE));
	}
}
