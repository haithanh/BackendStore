<?php

namespace App\Http\Controllers\Logs;

use App\UserActionLog;
use App\Http\Controllers\ApiController;
use App\Libraries\Sunries\Util;
use Illuminate\Http\Request;

class AdminActionLogsController extends ApiController
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
        $oAdministrators = UserActionLog::filter($aFilters, $iLimit, $iPage);

        return response()->json(Util::createResponse(MSG_SUCCESS, $oAdministrators->toArray()));
    }
}
