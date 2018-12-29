<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserActionLog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserActionLog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserActionLog query()
 */
class UserActionLog extends Model
{
	protected $table    = 'user_action_logs';
	protected $aRoles   = array();
	protected $fillable = array(
		'user_id',
		'item_id',
		'type',
		'old_data',
		'new_data'
	);
	protected $casts    = [
		'old_data' => 'array',
		'new_data' => 'array'
	];

	public static function saveLog(int $iAdminId, $iItemId, $sType, $aOldData = array(), $aNewData = array())
	{
		$aData = array(
			'admin_id' => $iAdminId,
			'item_id'  => $iItemId,
			'type'     => $sType,
			'old_data' => $aOldData,
			'new_data' => $aNewData
		);
		self::create($aData);
	}

	public static function filter($aFilters, $iLimit = 10, $iPage = 1)
	{
		$result = self::orderBy('id', 'DESC');
		foreach ($aFilters as $sKey => $sValue)
		{
			if (empty($sValue))
			{
				continue;
			}
			switch ($sKey)
			{
				case "admin_id":
					$result->where("admin_id", '=', $sValue);
					break;
				case "item_id":
					$result->where("item_id", '=', $sValue);
					break;
				case "type":
					$result->where("type", '=', $sValue);
					break;
				case "from_date":
					$result->where("created_at", '>=', $sValue);
					break;
				case "to_date":
					$result->where("created_at", '<=', $sValue);
					break;
				case "order_by":
					$type = "DESC";
					if (isset($aFilters["order_type"]) && $aFilters["order_type"] != "DESC")
					{
						$type = "ASC";
					}
					$result->orderBy($sValue, $type);
					break;
			}
		}

		return $result->paginate($iLimit, ['*'], 'page', $iPage);
	}
}
