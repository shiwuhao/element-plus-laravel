<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Shiwuhao\Rbac\Models\Permission as RbacPermission;

/**
 * App\Models\Permission
 *
 * @property int $id
 * @property int $pid 父级ID
 * @property string $permissible_type
 * @property int $permissible_id
 * @property int sort
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
 * @method static Builder|Permission ofSearch($params)
 * @property-read \Illuminate\Database\Eloquent\Collection|Permission[] $children
 * @property-read int|null $children_count
 * @method static Builder|Permission ofParent()
 * @property-read string $permissible_type_label
 */
class Permission extends RbacPermission
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
    protected $appends = [
        'permissible_type_label'
    ];

    /**
     * @var string[]
     */
    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    /**
     * @return HasMany
     */
    public function children(): HasMany
    {
        return $this->hasMany(Permission::class, 'pid', 'id');
    }

    /**
     * permissible_type_label
     * @return string
     */
    public function getPermissibleTypeLabelAttribute(): string
    {
        switch ($this->permissible_type) {
            case 'actions':
                return '动作';
            case 'menus':
                return '菜单';
            default:
                return '';
        }
    }

    /**
     * @param Builder $builder
     * @param array $params
     * @return Builder
     */
    public function scopeOfSearch(Builder $builder, array $params = []): Builder
    {
        if (!empty($params['type']) && $params['type'] != 'all') {
            $builder->where('permissible_type', $params['type']);
        }

        return $builder;
    }

}
