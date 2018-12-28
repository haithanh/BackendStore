<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Libraries\Sunries\Util;

class ApiController extends BaseController
{
	protected $aMessage = array();

	public function __construct()
	{
		$this->aMessage = array(
			MSG_ERROR_AUTHEN             => __("Failure authentication"),
			MSG_ERROR_VALIDATION         => __("Validation failed"),
			MSG_ERROR_ACTION             => __("Action failed"),
			MSG_ERROR_LOGIN              => __("Incorrect username, email, or password"),
			MSG_ERROR_TOKEN_CREATE       => __("Failed to create token"),
			MSG_ERROR_PARAMS             => __("Incorrect parameters"),
			MSG_ERROR_RETYPE_PASSWORD    => __("Re-type password and new password is not the same"),
			MSG_ERROR_OLD_PASSWORD       => __("Incorrect old password"),
			MSG_ERROR_PARAMS_ROLE        => __("Can not parse role"),
			MSG_ERROR_USER_NOT_FOUND     => __("User not found"),
			MSG_ERROR_USER_DISABLED      => __("User is disabled"),
			MSG_ERROR_USER_COINS         => __("Incorrect coins"),
			MSG_ERROR_USER_COINS_GREATER => __("Coins must greater than user's coins"),
			MSG_ERROR_GAME_NOT_FOUND     => __("Game not found"),
			MSG_ERROR_SERVER_NOT_FOUND   => __("Server not found"),
			MSG_SUCCESS                  => __("Success"),
			MSG_SUCCESS_UPDATE           => __("Successfully updated"),
			MSG_SUCCESS_CREATE           => __("Successfully created"),
			MSG_SUCCESS_DELETE           => __("Successfully deleted"),
			MSG_ERROR_CAPTCHA            => __("Captcha failed")
		);
	}

	protected function getMessage($iMessage)
	{
		return $this->aMessage[$iMessage];
	}
}
