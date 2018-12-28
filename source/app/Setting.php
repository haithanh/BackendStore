<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Setting
 *
 * @property int                 $id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string              $value
 * @property string              $key
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Setting whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Setting whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Setting whereKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Setting whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Setting whereValue($value)
 * @mixin \Eloquent
 */
class Setting extends Model
{
    protected $table = 'settings';
    protected $fillable = array(
        'key',
        'value',
    );

    public static function getGameSetting($sKey, $iGameId = 0)
    {
        $aSetting = array();
        $oSetting = self::where("key", "=", $sKey)->first();
        if (!empty($oSetting))
        {
            $aSetting = json_decode($oSetting->value, true);
            if (!empty($aSetting) && is_numeric($iGameId) && $iGameId > 0)
            {
                $sKeyGame = 'game_' . $iGameId;
                if (!empty($aSetting) && isset($aSetting[$sKeyGame]))
                {
                    $aSetting = $aSetting[$sKeyGame];
                }
            }
        }
        return $aSetting;
    }
}
