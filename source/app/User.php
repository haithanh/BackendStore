<?php

namespace App;

use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Validation\Rule;
use Tymon\JWTAuth\Contracts\JWTSubject;

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
 * @property int|null            $gate_id
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereGateId($value)
 */
class User extends \Illuminate\Foundation\Auth\User implements JWTSubject
{
    use SoftDeletes;
    protected $table = 'users';
    protected $aRoles = array();
    protected $fillable = array(
        'username',
        'password',
        'email',
        'status',
        'information'
    );
    //protected $maps   = [
    //	'name' => 'username'
    //];
    protected $hidden = [
        'password',
        'remember_token',
    ];
    protected $casts = [
        'information' => 'array',
    ];

    public function getRoles()
    {
        if (empty($this->aRoles))
        {
            $oRoles = DB::table('admins_roles')
                ->join('roles', 'admins_roles.role_id', '=', 'roles.id')
                ->where("admins_roles.admin_id", "=", $this->id)
                ->get();
            $aRoles = array();
            if (!empty($oRoles))
            {
                foreach ($oRoles as $oRole)
                {
                    $aRoles[$oRole->game_id][] = $oRole->name;
                }
            }
            $this->aRoles = $aRoles;
        }

        return $this->aRoles;
    }

    public function getRolesByName()
    {
        $oRoles = DB::table('admins_roles')
            ->join('roles', 'admins_roles.role_id', '=', 'roles.id')
            ->where("admins_roles.admin_id", "=", $this->id)
            ->get();
        $aRoles = array();
        if (!empty($oRoles))
        {
            foreach ($oRoles as $oRole)
            {
                $aRoles[$oRole->name][] = $oRole->game_id;
            }
        }
        return $aRoles;
    }

    public function getRolesDetail()
    {
        if (empty($this->aRoles))
        {
            $oRoles = DB::table('admins_roles')
                ->join('roles', 'admins_roles.role_id', '=', 'roles.id')
                ->where("admins_roles.admin_id", "=", $this->id)
                ->get();
            $aRoles = array();
            $aTemp  = array();
            if (!empty($oRoles))
            {
                $iCount = 0;
                foreach ($oRoles as $oRole)
                {
                    if (!isset($aTemp[$oRole->role_id]))
                    {
                        $aTemp[$oRole->role_id] = $iCount;
                        $iCount++;
                    }
                    $iIndex = $aTemp[$oRole->role_id];
                    if (!isset($aRoles[$iIndex]))
                    {
                        $aRoles[$iIndex] = array(
                            "id"    => $oRole->role_id,
                            "name"  => $oRole->name,
                            "games" => array()
                        );
                    }
                    $aRoles[$iIndex]["games"][] = $oRole->game_id;
                }
            }
            $this->aRoles = $aRoles;
        }

        return $this->aRoles;
    }

    public function getGamesIdByRole($sRole)
    {
        $aGameId = array();
        if ($this->isSuperAdmin())
        {
            return $aGameId = Games::all()->pluck('id')->toArray();
        }
        $aRoles = $this->getRolesByName();

        if (isset($aRoles[$sRole]))
        {
            $aGameId = $aRoles[$sRole];
        }

        if (isset($aRoles[ROLE_ADMIN]))
        {
            $aGameId = array_merge($aGameId, $aRoles[ROLE_ADMIN]);
        }

        return $aGameId;
    }

    public function hasRoles($aCheckRoles, $iGameId = 1)
    {
        if ($this->isSuperAdmin())
        {
            return true;
        }
        if ($iGameId > 1)
        {
            $aRoles = $this->getRoles();
            if (!empty($aRoles))
            {
                $aGameRoles = $aRoles[$iGameId];
                if (array_intersect($aCheckRoles, $aGameRoles))
                {
                    return true;
                }
            }
        }
        else
        {
            $aRoles        = $this->getRolesByName();
            $aCheckRoles[] = ROLE_ADMIN;
            foreach ($aCheckRoles as $sRole)
            {
                if (isset($aRoles[$sRole]))
                {
                    return true;
                }
            }
        }


        return false;
    }

    public function isSuperAdmin()
    {
        $aRoles = $this->getRoles();
        if (!empty($aRoles) && isset($aRoles[ALL_GAME_ID]))
        {
            if (in_array(ROLE_SUPER_ADMIN, $aRoles[ALL_GAME_ID]))
            {
                return true;
            }
        }

        return false;
    }

    /**
     * Check multiple roles
     *
     * @param array $roles
     */


    public function validator($data, $id = 0)
    {
        $aRules = array(
            'username' => array(
                'required',
                Rule::unique($this->table, 'username')->ignore($id),
                'min:5'
            ),
            'email'    => array(
                'required',
                Rule::unique($this->table, 'email')->ignore($id),
                'min:5',
                'email'
            ),
            'status'   => array(
                'required'
            )
        );
        if (!$id)
        {
            $aRules['password'] = array(
                'required',
                'min:5'
            );
        }
        $validator = \Validator::make($data, $aRules);
        if ($validator->fails())
        {
            return $validator->errors();
        }

        return false;
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        // TODO: Implement getJWTIdentifier() method.
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        // TODO: Implement getJWTCustomClaims() method.
        return ["user_type" => "admin"];
    }

    public static function filter($aFilters, $iLimit = 10, $iPage = 1)
    {
        $by = "id";
        if (isset($aFilters["order_by"]))
        {
            $by = $aFilters["order_by"];
        }
        $type = "DESC";
        if (isset($aFilters["order_type"]) && $aFilters["order_type"] != "DESC")
        {
            $type = "ASC";
        }
        $result = self::orderBy($by, $type);
        foreach ($aFilters as $sKey => $sValue)
        {
            if (empty($sValue))
            {
                if (!is_numeric($sValue))
                {
                    continue;
                }
            }
            switch ($sKey)
            {
                case "username":
                    $result->where("username", 'like', "%{$sValue}%");
                    break;
                case "email":
                    $result->where("email", 'like', "%{$sValue}%");
                    break;
                case "status":
                    $result->where("status", '=', $sValue);
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
