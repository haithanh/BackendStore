<?php

namespace App\Libraries\Sunries;

class Messages
{

    public static function get($iId)
    {
        $aMessages = array(
            MSG_ERROR_AUTHEN                 => __("Failure authentication"),
            MSG_ERROR_VALIDATION             => __("Validation failed"),
            MSG_ERROR_ACTION                 => __("Action failed"),
            MSG_ERROR_LOGIN                  => __("Incorrect username, email, or password"),
            MSG_ERROR_TOKEN_CREATE           => __("Failed to create token"),
            MSG_ERROR_PARAMS                 => __("Incorrect parameters"),
            MSG_ERROR_RETYPE_PASSWORD        => __("Re-type password and new password is not the same"),
            MSG_ERROR_OLD_PASSWORD           => __("Incorrect old password"),
            MSG_ERROR_PARAMS_ROLE            => __("Can not parse role"),
            MSG_ERROR_USER_NOT_FOUND         => __("User not found"),
            MSG_ERROR_USER_DISABLED          => __("User is disabled"),
            MSG_ERROR_USER_COINS             => __("Incorrect coins"),
            MSG_ERROR_USER_COINS_GREATER     => __("Coins must greater than user's coins"),
            MSG_ERROR_GAME_NOT_FOUND         => __("Game not found"),
            MSG_ERROR_SERVER_NOT_FOUND       => __("Server not found"),
            MSG_SUCCESS                      => __("Success"),
            MSG_SUCCESS_UPDATE               => __("Successfully updated"),
            MSG_SUCCESS_CREATE               => __("Successfully created"),
            MSG_SUCCESS_DELETE               => __("Successfully deleted"),
            MSG_ERROR_CAPTCHA                => __("Captcha failed"),
            MSG_ERROR_GOLD_INCORRECT         => __("Incorrect gold"),
            MSG_ERROR_USER_NOT_AGENCY        => __("User is not agency"),
            MSG_ERROR_EVENT_NOT_FOUND        => __("Event not found"),
            MSG_ERROR_MAIL_NOT_FOUND         => __("Mail not found"),
            MSG_ERROR_NEWS_NOT_FOUND         => __("News not found"),
            MSG_ERROR_TOKEN_EXPIRED          => __("Token Expired"),
            MSG_ERROR_TOKEN_INVALID          => __("Token Invalid"),
            MSG_ERROR_TOKEN_PARSE            => __("Can not parse Token"),
            MSG_ERROR_TOKEN_REQUIRED         => __("Token Required"),
            MSG_ERROR_TRANSACTION_NOT_FOUND  => __("Transaction not found"),
            MSG_ERROR_WRONG_KEY              => __("Wrong Hash Key"),
            MSG_ERROR_TRANSACTION_DONE       => __("Transaction is done"),
            MSG_ERROR_TRANSACTION_NOT_ACTIVE => __("Transaction is not active"),
            MSG_ERROR_GAME_PAYMENT_GATE      => __("Can not use this payment gate"),
            MSG_ERROR_AGENCY_DISABLE         => __("Game không áp dụng agency"),
            MSG_ERROR_AGENCY_NOT_SETUP       => __("Game agency chưa được setup"),
            MSG_ERROR_AGENCY_OFF             => __("Game agency đang tắt"),
            MSG_ERROR_USER_DISABLE_FEATURE   => __('Bạn bị khoá chức năng này'),
            MSG_ERROR_AGENCY_TO_AGENCY       => __('Không được chuyển cho đại lý khác'),
            MSG_ERROR_GOLD_MIN_CHANGE        => __("Tối thiểu"),
            MSG_ERROR_GOLD_MAX_CHANGE        => __("Tối đa"),
            MSG_ERROR_CARD_WRONG_TELCO       => __("Nhà mạng không đúng"),
            MSG_ERROR_REWARD_NOT_FOUND       => __("Reward not found"),
            MSG_ERROR_REWARD_GET_FAIL        => __("Get Reward failed"),
            MSG_ERROR_REWARD_GAME_NOT_ACTIVE => __("Game không mở chức năng đổi thưởng"),
            MSG_REWARD_CARD_WAIT             => __("Thẻ đang được duyệt vui lòng đợi. "),
            MSG_ERROR_SUBGAME_NOT_FOUND      => __("Sub game not found"),
            MSG_ERROR_AUTHEN_FACEBOOK        => __("Cannot login with facebook"),
            MSG_ERROR_REGISTER               => __("Register fail"),
            MSG_ERROR_PERMISSION             => __("Permission denied"),
            MSG_ERROR_REWARD_LIMIT_NUMBER    => __("Bạn đã đạt giới hạn số lần đổi 1 ngày"),
            MSG_ERROR_REWARD_LIMIT_VND       => __("Bạn đã đạt giới hạn số tiền đổi 1 ngày"),
            MSG_ERROR_REWARD_LIMIT_BAN       => __("Bạn đã bị tạm khoá đổi, vui lòng liên hệ admin"),

        );
        if (isset($aMessages[$iId]))
        {
            return $aMessages[$iId];
        }
        else
        {
            return __("Fail");
        }
    }
}