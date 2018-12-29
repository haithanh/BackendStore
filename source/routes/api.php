<?php

use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\JWTAuth;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//<editor-fold desc="Authentication">
Route::group([
    'prefix'    => '',
    'namespace' => 'Auth'
], function () {
    Route::post('login', 'AuthController@login');
    Route::group(['middleware' => 'jwt-auth:web'], function () {
        Route::post('change-password', 'AuthController@changePassword');
        Route::post('account', 'AuthController@account');
        Route::group(['middleware' => 'check.admin.roles:' . ROLE_SUPER_ADMIN], function () {
            Route::get('', 'AdminManageController@get');
            Route::post('', 'AdminManageController@create');
            Route::delete('{id}', 'AdminManageController@deleteObj');
        });
        Route::group(['middleware' => 'check.admin.roles.owner:' . ROLE_SUPER_ADMIN], function () {
            Route::put('{id}', 'AdminManageController@update');
            Route::get('{id}', 'AdminManageController@detail');
        });
    });
});

//</editor-fold>
//<editor-fold desc="Admin Roles Router">
Route::group([
    'prefix' => 'roles'
], function () {
    Route::group(['middleware' => 'jwt-auth:web'], function () {
        Route::group(['middleware' => 'check.admin.roles:' . ROLE_ADMIN], function () {
            Route::get('', 'Administrators\AdminRoleController@get');
            Route::put('', 'Administrators\AdminRoleController@update');
        });
    });
});
//</editor-fold>

//<editor-fold desc="Admin Logs">
Route::group([
    'prefix' => 'logs'
], function () {
    Route::group(['middleware' => 'jwt-auth:web'], function () {
        Route::group(['middleware' => 'check.admin.roles:' . ROLE_LOGS], function () {
            Route::get('action-logs', 'Logs\AdminActionLogsController@get');
            Route::get('add-gold-logs', 'Logs\CmsLogsController@addGoldLog');
        });
    });
});
//</editor-fold>

//<editor-fold desc="Admin Users">
Route::group([
    'prefix' => 'users'
], function () {
    Route::group(['middleware' => array('jwt-auth:web')], function () {
        Route::group(['middleware' => 'check.admin.roles:' . ROLE_MANAGE_USER . "|" . ROLE_MANAGE_GAME], function () {
            Route::get('', 'User\CmsUserController@get');
            Route::delete('{id}', 'User\CmsUserController@deleteObj');
            Route::put('{id}', 'User\CmsUserController@update');
            Route::get('{id}', 'User\CmsUserController@detail');
            Route::get('third-party-user/{id}', 'User\CmsUserController@thirdPartyUser');
        });
    });
});
//</editor-fold>

//<editor-fold desc="Users">
Route::group([
    'prefix' => ''
], function () {
    Route::group([
        'prefix' => 'users',
    ], function () {
        Route::get('check-token', 'User\AuthController@checkGameToken');
        Route::group(['middleware' => array('check.game.id')], function () {
            Route::post('', 'User\UserController@create');
            Route::group(['middleware' => array('jwt-auth:web')], function () {
                Route::post('change-password', 'User\AuthController@changePassword');
                Route::post('minus-coins', 'User\UserPaymentController@coins');
                Route::put('', 'User\UserController@update');
                Route::get('', 'User\UserController@detail');

            });
        });
    });
});
//</editor-fold>

//<editor-fold desc="Mail">
Route::group([
    'prefix' => ''
], function () {
    Route::group([
        'namespace' => 'Mail',
        'prefix'    => 'mail'
    ], function () {
        Route::group(['middleware' => array('jwt-auth:web')], function () {
            Route::get('', 'MailController@get');
            Route::get('{id}', 'MailController@detail');
            Route::post('', 'MailController@create');
            Route::put('{id}', 'MailController@update');
            Route::delete('{id}', 'MailController@deleteObj');
        });
    });
});
//</editor-fold>
