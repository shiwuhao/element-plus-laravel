<?php

namespace App\Models;

/**
 * App\Models\Permission
 *
 * @property int $id
 * @property int $pid 父级ID
 * @property string $permissible_type
 * @property int $permissible_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $permissible
 * @property-read \Illuminate\Database\Eloquent\Collection|\Shiwuhao\Rbac\Models\Permission[] $roles
 * @property-read int|null $roles_count
 * @method static \Illuminate\Database\Eloquent\Builder|Permission newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Permission newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Permission query()
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission wherePermissibleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission wherePermissibleType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission wherePid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Permission extends \Shiwuhao\Rbac\Models\Permission
{
    /**
     * @var string[]
     */
    protected $hidden = [
        'pivot'
    ];

    /**
     * @var string[]
     */
    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];
}
