<?php
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App{
/**
 * App\Transaction
 *
 * @mixin \Eloquent
 * @property int                  $id
 * @property string|null          $card_number
 * @property string|null          $card_serial
 * @property int|null             $card_telecom 1-Vina, 2-Mobi, 3-Viettel, ...
 * @property int|null             $type         1-Card, 2-Bank, ...
 * @property string|null          $bank
 * @property int|null             $value
 * @property int                  $user_id
 * @property int                  $gate_id
 * @property string|null          $gate_number
 * @property string|null          $server_number
 * @property string|null          $information
 * @property int|null             $payment_client_id
 * @property int                  $status
 * @property \Carbon\Carbon|null  $created_at
 * @property \Carbon\Carbon|null  $updated_at
 * @property string|null          $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Transaction whereBank($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Transaction whereCardNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Transaction whereCardSerial($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Transaction whereCardTelecom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Transaction whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Transaction whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Transaction whereGateId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Transaction whereGateNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Transaction whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Transaction whereInformation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Transaction whereServerNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Transaction whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Transaction whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Transaction whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Transaction whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Transaction whereValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Transaction wherePaymentClientId($value)
 * @property int|null             $game_id
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Transaction whereGameId($value)
 * @property int                  $game_status
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Transaction whereGameStatus($value)
 * @property int|null             $game_user_id
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Transaction whereGameUserId($value)
 * @property string|null          $game_information
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Transaction whereGameInformation($value)
 * @property string|null          $game_message
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Transaction whereGameMessage($value)
 * @property-read \App\Games|null $game
 * @property-read \App\User|null  $user
 */
	class Transaction extends \Eloquent {}
}

namespace App{
/**
 * App\Roles
 *
 * @property int $id
 * @property string $name
 * @property array $information
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Roles whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Roles whereInformation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Roles whereName($value)
 * @mixin \Eloquent
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Roles whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Roles whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Roles whereUpdatedAt($value)
 */
	class Roles extends \Eloquent {}
}

namespace App{
/**
 * App\Server
 *
 * @property int                 $id
 * @property string              $name
 * @property array               $information
 * @property int                 $status
 * @property int                 $game_id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null         $deleted_at
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Server onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Server whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Server whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Server whereGameId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Server whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Server whereInformation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Server whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Server whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Server whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Server withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Server withoutTrashed()
 * @mixin \Eloquent
 * @property string $class
 * @property string $password
 * @property string $master_url
 * @property int $have_server
 * @property string|null $api_url
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Server whereApiUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Server whereClass($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Server whereHaveServer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Server whereMasterUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Server wherePassword($value)
 */
	class Server extends \Eloquent {}
}

namespace App{
/**
 * App\PaymentGate
 *
 * @property int $id
 * @property string $name
 * @property array $information
 * @property int $status
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PaymentGate whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PaymentGate whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PaymentGate whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PaymentGate whereInformation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PaymentGate whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PaymentGate whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PaymentGate whereUpdatedAt($value)
 * @mixin \Eloquent
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\PaymentGate onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Query\Builder|\App\PaymentGate withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\PaymentGate withoutTrashed()
 */
	class PaymentGate extends \Eloquent {}
}

namespace App{
/**
 * App\Mail
 *
 * @property int $id
 * @property string $title
 * @property string $description
 * @property int $read
 * @property int $game_id
 * @property int $user_id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Mail onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Mail whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Mail whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Mail whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Mail whereGameId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Mail whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Mail whereRead($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Mail whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Mail whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Mail whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Mail withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Mail withoutTrashed()
 * @mixin \Eloquent
 */
	class Mail extends \Eloquent {}
}

namespace App{
/**
 * App\AdminRoles
 *
 * @property int $admin_id
 * @property int $role_id
 * @property int $game_id
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AdminRoles whereAdminId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AdminRoles whereGameId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AdminRoles whereRoleId($value)
 * @mixin \Eloquent
 */
	class AdminRoles extends \Eloquent {}
}

namespace App{
/**
 * App\Games
 *
 * @property int                 $id
 * @property string              $name
 * @property string              $class
 * @property array               $information
 * @property int                 $status
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null         $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Games whereClass($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Games whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Games whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Games whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Games whereInformation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Games whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Games whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Games whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string $password
 * @property string $master_url
 * @property int $have_server
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Games onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Games whereHaveServer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Games whereMasterUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Games wherePassword($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Games withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Games withoutTrashed()
 * @property string|null $api_url
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Games whereApiUrl($value)
 * @property string|null $IV
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Games whereIV($value)
 * @property int $party_payment
 * @property string|null $service_url
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Games wherePartyPayment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Games whereServiceUrl($value)
 */
	class Games extends \Eloquent {}
}

namespace App{
/**
 * App\User
 *
 * @property int                 $id
 * @property string              $username
 * @property string              $uid
 * @property string              $email
 * @property string              $password
 * @property int                 $is_test
 * @property array               $information
 * @property int                 $status
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null         $deleted_at
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\User onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereInformation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereIsTest($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereUid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereUsername($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\User withoutTrashed()
 * @mixin \Eloquent
 * @property int                 $coins
 * @property string|null         $last_login
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereCoins($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereLastLogin($value)
 * @property string              $display_name
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereDisplayName($value)
 */
	class User extends \Eloquent {}
}

namespace App{
/**
 * App\Events
 *
 * @property int $id
 * @property string $name
 * @property string $code
 * @property string $class
 * @property array $information
 * @property int $sub_game_id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Events onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Events whereClass($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Events whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Events whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Events whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Events whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Events whereInformation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Events whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Events whereSubGameId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Events whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Events withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Events withoutTrashed()
 * @mixin \Eloquent
 * @property-read \App\SubGame $subGame
 */
	class Events extends \Eloquent {}
}

namespace App{
/**
 * App\UserLog
 *
 * @mixin \Eloquent
 * @property int $id
 * @property array $information
 * @property int $game_id
 * @property int $user_id
 * @property string|null $reason
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\UserLog onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserLog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserLog whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserLog whereGameId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserLog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserLog whereInformation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserLog whereReason($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserLog whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserLog whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\UserLog withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\UserLog withoutTrashed()
 * @property string|null $server_reason
 * @property int|null $server_id
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserLog whereServerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserLog whereServerReason($value)
 */
	class UserLog extends \Eloquent {}
}

namespace App{
/**
 * App\InternalLog
 *
 * @property int                 $id
 * @property string|null         $information
 * @property array               $old_data
 * @property array               $new_data
 * @property int                 $game_id
 * @property int                 $item_id
 * @property string              $type
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\InternalLog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\InternalLog whereGameId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\InternalLog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\InternalLog whereInformation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\InternalLog whereItemId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\InternalLog whereNewData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\InternalLog whereOldData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\InternalLog whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\InternalLog whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property int|null            $sub_game_real_id
 * @method static \Illuminate\Database\Eloquent\Builder|\App\InternalLog whereSubGameRealId($value)
 * @property int|null            $sub_game_id
 * @method static \Illuminate\Database\Eloquent\Builder|\App\InternalLog whereSubGameId($value)
 */
	class InternalLog extends \Eloquent {}
}

namespace App{
/**
 * App\GamePaymentGate
 *
 * @property int $id
 * @property array $information
 * @property int $status
 * @property int $payment_gate_id
 * @property int $game_id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\GamePaymentGate onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\GamePaymentGate whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\GamePaymentGate whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\GamePaymentGate whereGameId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\GamePaymentGate whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\GamePaymentGate whereInformation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\GamePaymentGate wherePaymentGateId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\GamePaymentGate whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\GamePaymentGate whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\GamePaymentGate withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\GamePaymentGate withoutTrashed()
 */
	class GamePaymentGate extends \Eloquent {}
}

namespace App{
/**
 * App\SubGame
 *
 * @property int $id
 * @property string $name
 * @property array $information
 * @property int $status
 * @property int $game_id
 * @property int $real_game_id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\SubGame onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SubGame whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SubGame whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SubGame whereGameId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SubGame whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SubGame whereInformation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SubGame whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SubGame whereRealGameId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SubGame whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SubGame whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SubGame withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\SubGame withoutTrashed()
 * @mixin \Eloquent
 * @property-read \App\Games $game
 */
	class SubGame extends \Eloquent {}
}

namespace App{
/**
 * App\UserCoinsLog
 *
 * @property int $id
 * @property int $user_id
 * @property int|null $game_id
 * @property int|null $payment_client_id
 * @property int|null $coins_change
 * @property int|null $coins_after
 * @property string|null $reason
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserCoinsLog whereCoinsAfter($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserCoinsLog whereCoinsChange($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserCoinsLog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserCoinsLog whereGameId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserCoinsLog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserCoinsLog wherePaymentClientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserCoinsLog whereReason($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserCoinsLog whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserCoinsLog whereUserId($value)
 * @mixin \Eloquent
 */
	class UserCoinsLog extends \Eloquent {}
}

namespace App{
/**
 * App\UserGameSeeder
 *
 * @mixin \Eloquent
 * @property int                 $id
 * @property string|null         $information
 * @property int                 $game_id
 * @property int                 $user_id
 * @property string|null         $remember_token
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null         $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserGame whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserGame whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserGame whereGameId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserGame whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserGame whereInformation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserGame whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserGame whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserGame whereUserId($value)
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\UserGame onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Query\Builder|\App\UserGame withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\UserGame withoutTrashed()
 */
	class UserGame extends \Eloquent {}
}

namespace App{
/**
 * App\AdminActionLog
 *
 * @property int                 $id
 * @property int                 $admin_id
 * @property int                 $item_id
 * @property string              $type
 * @property array               $old_data
 * @property array               $new_data
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserActionLog whereAdminId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserActionLog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserActionLog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserActionLog whereItemId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserActionLog whereNewData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserActionLog whereOldData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserActionLog whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserActionLog whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class AdminActionLog extends \Eloquent {}
}

namespace App{
/**
 * App\Administrator
 *
 * @property int                 $id
 * @property string              $username
 * @property string              $email
 * @property string              $password
 * @property array               $information
 * @property int                 $status
 * @property string|null         $remember_token
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null         $deleted_at
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\User onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereInformation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereUsername($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\User withoutTrashed()
 * @mixin \Eloquent
 */
	class Administrator extends \Eloquent {}
}

