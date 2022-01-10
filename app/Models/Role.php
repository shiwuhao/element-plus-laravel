<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Shiwuhao\Rbac\Models\Role as RbacRole;

/**
 * App\Models\Role
 *
 * @property int $id
 * @property string $name 唯一标识
 * @property string $label
 * @property string $desc
 * @property bool $status 状态
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \datetime|null $created_at
 * @property \datetime|null $updated_at
 * @property-read string $status_label
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Permission[] $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $users
 * @property-read int|null $users_count
 * @method static Builder|Role newModelQuery()
 * @method static Builder|Role newQuery()
 * @method static Builder|Role ofSearch($params)
 * @method static \Illuminate\Database\Query\Builder|Role onlyTrashed()
 * @method static Builder|Role query()
 * @method static Builder|Role whereCreatedAt($value)
 * @method static Builder|Role whereDeletedAt($value)
 * @method static Builder|Role whereDesc($value)
 * @method static Builder|Role whereId($value)
 * @method static Builder|Role whereLabel($value)
 * @method static Builder|Role whereName($value)
 * @method static Builder|Role whereStatus($value)
 * @method static Builder|Role whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Role withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Role withoutTrashed()
 * @mixin \Eloquent
 */
class Role extends RbacRole
{
    /**
     * 管理员角色标识
     */
    const ADMINISTRATOR = 'Administrator';

    /**
     * @var string[]
     */
    protected $fillable = [
        'name', 'label', 'desc', 'status'
    ];

    /**
     * @var string[]
     */
    protected $hidden = [
        'pivot', 'deleted_at', 'updated_at',
    ];

    /**
     * @var string[]
     */
    protected $appends = [
        'status_label'
    ];

    /**
     * @var string[]
     */
    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    /**
     * permission_ids
     * @return array
     */
    public function getPermissionIdsAttribute(): array
    {
        return $this->permissions->pluck('id')->toArray();
    }

    /**
     * search
     * @param Builder $builder
     * @param $params
     * @return Builder
     */
    public function scopeOfSearch(Builder $builder, $params): Builder
    {
        if (!empty($params['id'])) {
            $builder->where('id', "{$params['id']}");
        }

        if (!empty($params['name'])) {
            $builder->where('name', 'like', "{$params['name']}%");
        }

        if (!empty($params['label'])) {
            $builder->where('label', 'like', "{$params['label']}%");
        }
        return $builder;
    }

    /**
     * @return string
     */
    public function getStatusLabelAttribute(): string
    {
        return $this->status ? '正常' : '已禁用';
    }
}
