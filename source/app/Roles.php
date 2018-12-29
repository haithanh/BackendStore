<?php

namespace App;

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
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Roles newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Roles newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Roles query()
 */
class Roles extends \Eloquent
{
	protected $table = 'roles';
	protected $casts = [
		'information' => 'array',
	];
}
