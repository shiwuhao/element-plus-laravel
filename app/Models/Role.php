<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Shiwuhao\Rbac\Traits\RoleTrait;

/**
 * App\Models\Role
 *
 * @property int $id
 * @property string $name 唯一标识
 * @property string $title
 * @property string $remark
 * @property int $status 状态
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \datetime|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read string $status_label
 * @method static Builder|Role newModelQuery()
 * @method static Builder|Role newQuery()
 * @method static Builder|Role ofSearch($params = [])
 * @method static \Illuminate\Database\Query\Builder|Role onlyTrashed()
 * @method static Builder|Role query()
 * @method static Builder|Role whereCreatedAt($value)
 * @method static Builder|Role whereDeletedAt($value)
 * @method static Builder|Role whereId($value)
 * @method static Builder|Role whereName($value)
 * @method static Builder|Role whereRemark($value)
 * @method static Builder|Role whereStatus($value)
 * @method static Builder|Role whereTitle($value)
 * @method static Builder|Role whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Role withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Role withoutTrashed()
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Permission[] $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $users
 * @property-read int|null $users_count
 */
class Role extends Model
{
    use HasFactory, SoftDeletes, RoleTrait;

    // 超级管理员标识
    const ADMINISTRATOR = 'administrator';

    /**
     * @var string[]
     */
    protected $fillable = [
        'name', 'title', 'remark', 'status'
    ];

    /**
     * @var string[]
     */
    protected $hidden = [
        'updated_at'
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
    ];

    /** status_label
     * @return string
     */
    public function getStatusLabelAttribute(): string
    {
        return $this->status ? '正常' : '禁用';
    }

    /**
     * permission_ids
     * @return array
     */
    public function getPermissionIdsAttribute(): array
    {
        return $this->permissions->pluck('id')->toArray();
    }

    /**
     * @param Builder $builder
     * @param array $params
     * @return Builder
     */
    public function scopeOfSearch(Builder $builder, $params = []): Builder
    {
        if (!empty($params['id']) && $params['id']) {
            $builder->where('id', $params['id']);
        }
        if (!empty($params['title']) && $params['title']) {
            $builder->where('title', 'like', "{$params['title']}%");
        }

        if (!empty($params['name']) && $params['name']) {
            $builder->where('name', 'like', "{$params['name']}%");
        }

        return $builder;
    }
}
