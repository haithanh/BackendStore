<?php

namespace App\Http\Controllers\User;

use App\UserActionLog;
use App\AgencyLogs;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use App\Libraries\Sunries\Game\GameClass\MainGameClass;
use App\Libraries\Sunries\Util;
use App\Reward;
use App\RewardsLogs;
use App\Transaction;
use App\User;
use App\UserGame;
use Illuminate\Http\Request;
use JWTAuth;
use JWTAuthException;

class CmsUserController extends ApiController
{
    public function get(Request $request)
    {
        $iLimit   = $request->get("limit", DEFAULT_LIMIT);
        $iPage    = $request->get("page", 1);
        $aFilters = $request->all();
        $oUsers   = User::filter($aFilters, $iLimit, $iPage);

        return response()->json(Util::createResponse(MSG_SUCCESS, $oUsers->toArray()));
    }

    /**
     * @param Request $request
     * @param int     $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, int $id)
    {
        try
        {
            $aData = $request->all();
            if (isset($aData["password"]) && !empty($aData["password"]))
            {
                $aData["password"] = \Hash::make($aData["password"]);
            }
            else
            {
                unset($aData["password"]);
            }
            unset($aData["coins"]);
            if (empty($id) || empty($aData))
            {
                return response()->json(Util::createResponse(MSG_ERROR_PARAMS));
            }
            $oUser = User::find($id);

            if (empty($oUser))
            {
                return response()->json(Util::createResponse(MSG_ERROR_USER_NOT_FOUND));
            }
            $aOldData = $oUser->toArray();
            $oUser->fill($aData);
            $aCheckData = $oUser->toArray();
            $aValidate  = $oUser->validator($aCheckData, $id);

            if ($aValidate)
            {

                $response["errors"] = $aValidate;

                return response()->json(Util::createResponse(MSG_ERROR_VALIDATION, $response));
            }

            if ($oUser->save())
            {
                UserActionLog::saveLog($request->user()->id, $oUser->id, ACTION_LOG_TYPE_USER, $aOldData, $oUser->toArray());
                if ($aOldData['is_agency'] != $oUser->is_agency)
                {
                    if ($oUser->is_agency)
                    {
                        $sReason = __("Cấp quyền Agency");
                    }
                    else
                    {
                        $sReason = __("Huỷ quyền Agency");
                    }
                    AgencyLogs::create(array(
                        'order_id'    => AgencyLogs::getRandOrderId(),
                        'admin_id'    => $request->user()->id,
                        'from_user'   => null,
                        'to_user'     => $oUser->id,
                        'type'        => AGENCY_LOG_TYPE_GRANT_PERMISSION,
                        'status'      => 1,
                        'gold'        => 0,
                        'percent_fee' => 0,
                        'gold_fee'    => 0,
                        'reason'      => $sReason
                    ));

                }
            }

            return response()->json(Util::createResponse(MSG_SUCCESS_UPDATE, $oUser->toArray()));

        }
        catch (\Exception $e)
        {
            return response()->json(Util::createResponse(MSG_ERROR_ACTION, array(), $e->getMessage()));
        }

    }

    /**
     * @param Request $request
     * @param int     $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteObj(Request $request, int $id)
    {
        /**
         * @var User $oUser
         */
        try
        {
            if (empty($id))
            {
                return response()->json(Util::createResponse(MSG_ERROR_PARAMS));
            }

            $oUser = User::find($id);

            if (empty($oUser))
            {
                return response()->json(Util::createResponse(MSG_ERROR_USER_NOT_FOUND));
            }
            $aOldData = $oUser->toArray();
            if ($oUser->delete())
            {
                UserActionLog::saveLog($request->user()->id, $oUser->id, ACTION_LOG_TYPE_USER, $aOldData, array());
            }

            return response()->json(Util::createResponse(MSG_SUCCESS_DELETE, $oUser->toArray()));
        }
        catch (\Exception $e)
        {
            return response()->json(Util::createResponse(MSG_ERROR_ACTION, array(), $e->getMessage()));
        }
    }

    /**
     * @param Request $request
     * @param int     $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function detail(Request $request, int $id)
    {
        /**
         * @var User $oUser
         */
        try
        {
            if (empty($id))
            {
                return response()->json(Util::createResponse(MSG_ERROR_PARAMS));
            }

            $oUser = User::find($id);

            if (empty($oUser))
            {
                return response()->json(Util::createResponse(MSG_ERROR_USER_NOT_FOUND));
            }
            $oGame = $oUser->game;
            if (!empty($oGame))
            {
                $sClassGame = 'App\\Libraries\\Sunries\\Game\\' . $oGame->class;
                /**
                 * @var MainGameClass $oClassGame
                 */
                $oClassGame           = new $sClassGame();
                $sResult              = $oClassGame->getDetail($oUser->uid);
                $oUser["game_detail"] = $sResult;
            }
            $oUser                                     = $oUser->toArray();
            $oUser["games"]                            = UserGame::where("user_id", $id)->get();
            $oUser["report"]                           = array();
            $oUser["report"]["total_charge"]           = Transaction::getTotalChargeById($oUser['id']);
            $oUser["report"]["total_charge_count"]     = Transaction::getTotalCountChargeById($oUser['id']);
            $oUser["report"]["total_gold_reward"]      = RewardsLogs::getTotalGoldByUserId($oUser['id']);
            $oUser["report"]["total_vnd_reward"]       = RewardsLogs::getTotalVndByUserId($oUser['id']);
            $oUser["report"]["total_reward_count"]     = RewardsLogs::getTotalCountByUserId($oUser['id']);
            $oUser["report"]["total_agency_admin_to"]  = AgencyLogs::getTotalAdminTo($oUser['id']);
            $oUser["report"]["total_agency_user_to"]   = AgencyLogs::getTotalUserTo($oUser['id']);
            $oUser["report"]["total_agency_user_from"] = AgencyLogs::getTotalUserFrom($oUser['id']);

            return response()->json(Util::createResponse(MSG_SUCCESS, $oUser));
        }
        catch (\Exception $e)
        {
            return response()->json(Util::createResponse(MSG_ERROR_ACTION, array(), $e->getMessage()));
        }
    }

    public function thirdPartyUser(Request $request, $id)
    {
        $aUser                                 = array();
        $aUser['id']                           = $id;
        $aUser["report"]                       = array();
        $aUser["report"]["total_charge"]       = Transaction::getTotalChargeByThirdUser($id);
        $aUser["report"]["total_charge_count"] = Transaction::getTotalCountChargeByThirdUser($id);
        $aUser["report"]["total_gold_reward"]  = RewardsLogs::getTotalGoldByThirdPartyUser($id);
        $aUser["report"]["total_vnd_reward"]   = RewardsLogs::getTotalVndByThirdPartyUser($id);
        $aUser["report"]["total_reward_count"] = RewardsLogs::getTotalCountByThirdPartyUser($id);
        return response()->json(Util::createResponse(MSG_SUCCESS, $aUser));
    }
}
