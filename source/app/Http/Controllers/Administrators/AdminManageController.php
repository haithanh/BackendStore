<?php

namespace App\Http\Controllers\Administrators;

use App\UserActionLog;
use App\User;
use App\Games;
use App\Http\Controllers\ApiController;
use App\Libraries\Sunries\Util;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminManageController extends ApiController
{

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function get(Request $request)
    {
        $iLimit          = $request->get("limit", DEFAULT_LIMIT);
        $iPage           = $request->get("page", 1);
        $aFilters        = $request->all();
        $oAdministrators = User::filter($aFilters, $iLimit, $iPage);

        return response()->json(Util::createResponse(MSG_SUCCESS, $oAdministrators->toArray()));
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Request $request)
    {
        $data       = $request->all();
        $adminModel = new User();
        try
        {
            $validate = $adminModel->validator($data);

            if ($validate)
            {
                $dataResponse["errors"] = $validate;

                return response()->json(Util::createResponse(MSG_ERROR_VALIDATION, $dataResponse), HTTP_ERROR_VALIDATION);
            }

            $data["password"] = Hash::make($data["password"]);
            $adminModel->fill($data);
            if ($adminModel->save())
            {
                UserActionLog::saveLog($request->user()->id, $adminModel->id, ACTION_LOG_TYPE_ADMIN, array(), $adminModel->toArray());
            }

            return response()->json(Util::createResponse(MSG_SUCCESS_CREATE, $adminModel->toArray()));
        }
        catch (\Exception $e)
        {
            return response()->json(Util::createResponse(MSG_ERROR_ACTION, array(), ": " . $e->getMessage()), HTTP_ERROR_SERVER);
        }
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
                $aData["password"] = Hash::make($aData["password"]);
            }
            else
            {
                unset($aData["password"]);
            }

            if (empty($id) || empty($aData))
            {
                return response()->json(Util::createResponse(MSG_ERROR_PARAMS), HTTP_ERROR_VALIDATION);
            }

            $oAdministrator = User::find($id);

            if (empty($oAdministrator))
            {
                return response()->json(Util::createResponse(MSG_ERROR_USER_NOT_FOUND), HTTP_ERROR_VALIDATION);
            }
            $aOldData = $oAdministrator->toArray();
            $oAdministrator->fill($aData);
            $aCheckData = $oAdministrator->toArray();
            $aValidate  = $oAdministrator->validator($aCheckData, $id);

            if ($aValidate)
            {

                $response["errors"] = $aValidate;

                return response()->json(Util::createResponse(MSG_ERROR_VALIDATION, $response), HTTP_ERROR_VALIDATION);
            }

            if ($oAdministrator->save())
            {
                UserActionLog::saveLog($request->user()->id, $oAdministrator->id, ACTION_LOG_TYPE_ADMIN, $aOldData, $oAdministrator->toArray());
            }

            return response()->json(Util::createResponse(MSG_SUCCESS_CREATE, $oAdministrator->toArray()));

        }
        catch (\Exception $e)
        {
            return response()->json(Util::createResponse(MSG_ERROR_ACTION, array(), ": " . $e->getMessage()), HTTP_ERROR_SERVER);
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
         * @var User $oAdministrator
         */
        try
        {
            if (empty($id))
            {
                return response()->json(Util::createResponse(MSG_ERROR_PARAMS), HTTP_ERROR_VALIDATION);
            }

            $oAdministrator = User::find($id);

            if (empty($oAdministrator))
            {
                return response()->json(Util::createResponse(MSG_ERROR_USER_NOT_FOUND), HTTP_ERROR_VALIDATION);
            }
            $aOldData = $oAdministrator->toArray();
            if ($oAdministrator->delete())
            {
                UserActionLog::saveLog($request->user()->id, $oAdministrator->id, ACTION_LOG_TYPE_ADMIN, $aOldData, array());
            }

            return response()->json(Util::createResponse(MSG_SUCCESS_DELETE, $oAdministrator->toArray()));
        }
        catch (\Exception $e)
        {
            return response()->json(Util::createResponse(MSG_ERROR_ACTION, array(), ": " . $e->getMessage()), HTTP_ERROR_SERVER);
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
         * @var User $oAdministrator
         */
        try
        {
            if (empty($id))
            {
                return response()->json(Util::createResponse(MSG_ERROR_PARAMS), HTTP_ERROR_VALIDATION);
            }

            $oAdministrator = User::find($id);

            if (empty($oAdministrator))
            {
                return response()->json(Util::createResponse(MSG_ERROR_USER_NOT_FOUND), HTTP_ERROR_VALIDATION);
            }
            $aAdministrator          = $oAdministrator->toArray();
            $aAdministrator["roles"] = $oAdministrator->getRolesDetail();

            return response()->json(Util::createResponse(MSG_SUCCESS, $aAdministrator));
        }
        catch (\Exception $e)
        {
            return response()->json(Util::createResponse(MSG_ERROR_ACTION, array(), ": " . $e->getMessage()), HTTP_ERROR_SERVER);
        }
    }
}
