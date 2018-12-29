<?php


//<editor-fold desc="Encrypt">
const DEFAULT_TTL              = 86400;
const EXPIRED_EMAIL            = 30; //days
const EXPIRED_FAIL_TRANSACTION = 7; //days
const RECALL_TRANSACTION       = 30; //minutes
const EXPIRED_PAYMENT_TOKEN    = 300;
const BASE_DIR                 = __DIR__;
const RESOURCE_DIR             = __DIR__ . "/resources";
//</editor-fold>

//<editor-fold desc="HTTP Status Code">
const HTTP_ERROR_VALIDATION = 400;
const HTTP_ERROR_AUTHEN     = 401;
const HTTP_ERROR_PERMISSION = 403;
const HTTP_ERROR_SERVER     = 500;
const HTTP_SUCCESS          = 200;
//</editor-fold>

//<editor-fold desc="Roles">
const ROLE_ADMIN        = "ROLE_ADMIN";
const ROLE_SUPER_ADMIN  = "ROLE_SUPER_ADMIN";
const ROLE_MANAGE_USER  = "ROLE_MANAGE_USER";
const ROLE_MANAGE_GAME  = "ROLE_MANAGE_GAME";
const ROLE_LOGS         = "ROLE_LOGS";
const ROLE_MANAGE_EVENT = "ROLE_MANAGE_EVENT";
const ROLE_REWARDS      = "ROLE_REWARDS";
const ROLE_AGENCY       = "ROLE_AGENCY";
const ROLE_GMTOOL       = "ROLE_GMTOOL";
const ROLE_TOOL         = "ROLE_TOOL";
const ROLE_REPORT_CHART = "ROLE_REPORT_CHART";

const GAME_INFO_SEPERATOR = '||||';

//</editor-fold>

//<editor-fold desc="Action logs type">
const ACTION_LOG_TYPE_ADMIN        = "admin";
const ACTION_LOG_TYPE_USER         = "user";
const ACTION_LOG_TYPE_GAME         = "game";
const ACTION_LOG_TYPE_SERVER       = "server";
const ACTION_LOG_TYPE_SUBGAME      = "sub_game";
const ACTION_LOG_TYPE_ROLE         = "role";
const ACTION_LOG_TYPE_EVENT        = "event";
const ACTION_LOG_TYPE_CALL_EVENT   = "call_event";
const ACTION_LOG_TYPE_PAYMENT_GATE = "payment_gate";
const ACTION_LOG_TYPE_NEWS         = "news";
const ACTION_LOG_TYPE_TRANSACTION  = "transaction";
//</editor-fold>

//<editor-fold desc="Messages">
const MSG_ERROR_AUTHEN                 = -1;
const MSG_ERROR_VALIDATION             = -2;
const MSG_ERROR_ACTION                 = -3;
const MSG_ERROR_LOGIN                  = -4;
const MSG_ERROR_TOKEN_CREATE           = -5;
const MSG_ERROR_PARAMS                 = -6;
const MSG_ERROR_RETYPE_PASSWORD        = -7;
const MSG_ERROR_OLD_PASSWORD           = -8;
const MSG_ERROR_PARAMS_ROLE            = -9;
const MSG_ERROR_USER_NOT_FOUND         = -10;
const MSG_ERROR_USER_DISABLED          = -11;
const MSG_ERROR_USER_COINS             = -12;
const MSG_ERROR_USER_COINS_GREATER     = -13;
const MSG_ERROR_GAME_NOT_FOUND         = -14;
const MSG_ERROR_SERVER_NOT_FOUND       = -15;
const MSG_ERROR_CAPTCHA                = -16;
const MSG_ERROR_GOLD_INCORRECT         = -17;
const MSG_ERROR_USER_NOT_AGENCY        = -18;
const MSG_ERROR_EVENT_NOT_FOUND        = -19;
const MSG_ERROR_MAIL_NOT_FOUND         = -20;
const MSG_ERROR_NEWS_NOT_FOUND         = -21;
const MSG_ERROR_TOKEN_EXPIRED          = -22;
const MSG_ERROR_TOKEN_INVALID          = -23;
const MSG_ERROR_TOKEN_PARSE            = -24;
const MSG_ERROR_TOKEN_REQUIRED         = -25;
const MSG_ERROR_TRANSACTION_NOT_FOUND  = -26;
const MSG_ERROR_WRONG_KEY              = -27;
const MSG_ERROR_TRANSACTION_DONE       = -28;
const MSG_ERROR_GAME_PAYMENT_GATE      = -29;
const MSG_ERROR_AGENCY_DISABLE         = -30;
const MSG_ERROR_AGENCY_NOT_SETUP       = -31;
const MSG_ERROR_AGENCY_OFF             = -32;
const MSG_ERROR_USER_DISABLE_FEATURE   = -33;
const MSG_ERROR_AGENCY_TO_AGENCY       = -34;
const MSG_ERROR_GOLD_MIN_CHANGE        = -35;
const MSG_ERROR_GOLD_MAX_CHANGE        = -36;
const MSG_ERROR_CARD_WRONG_TELCO       = -37;
const MSG_ERROR_TRANSACTION_NOT_ACTIVE = -38;
const MSG_ERROR_REWARD_NOT_FOUND       = -39;
const MSG_ERROR_REWARD_GET_FAIL        = -40;
const MSG_ERROR_REWARD_GAME_NOT_ACTIVE = -41;
const MSG_ERROR_SUBGAME_NOT_FOUND      = -42;
const MSG_ERROR_AUTHEN_FACEBOOK        = -43;
const MSG_ERROR_REGISTER               = -44;
const MSG_ERROR_PERMISSION             = -45;
const MSG_ERROR_REWARD_LIMIT_NUMBER    = -46;
const MSG_ERROR_REWARD_LIMIT_VND       = -47;
const MSG_ERROR_REWARD_LIMIT_BAN       = -48;
const MSG_SUCCESS                      = 200;
const MSG_SUCCESS_UPDATE               = 2;
const MSG_SUCCESS_CREATE               = 3;
const MSG_SUCCESS_DELETE               = 4;
const MSG_REWARD_CARD_WAIT             = 5;


//</editor-fold>

//<editor-fold desc="Setting">
const SETTING_PAYMENT_TICHHOP        = "tich_hop_card";
//</editor-fold>

//<editor-fold desc="User">
const USER_STATUS_ACTIVE = 1;
//</editor-fold>

//<editor-fold desc="Email">
const MAIL_SEP                  = ",";
const MAIL_TYPE_ERROR_EXCEPTION = 1;
const MAIL_TYPE_BAN_REWARD      = 2;
const MAIL_LIST_BAN_REWARD      = "me@hainguyen.space";
//</editor-fold>
