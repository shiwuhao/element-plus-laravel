<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Shiwuhao\Rbac\Models\Traits\PermissibleTrait;

/**
 * App\Models\Menu
 *
 * @property int $id
 * @property int $pid 父级ID
 * @property string $name 唯一标识
 * @property string $label 显示名称
 * @property string $type 菜单类型
 * @property string $url 页面地址
 * @property string $icon 图标
 * @property string|null $deleted_at
 * @property \datetime|null $created_at
 * @property \datetime|null $updated_at
 * @property-read string $alias
 * @property-read \Shiwuhao\Rbac\Models\Permission|null $permission
 * @method static \Illuminate\Database\Eloquent\Builder|Menu newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Menu newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Menu query()
 * @method static \Illuminate\Database\Eloquent\Builder|Menu whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Menu whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Menu whereIcon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Menu whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Menu whereLabel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Menu whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Menu wherePid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Menu whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Menu whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Menu whereUrl($value)
 * @mixin \Eloquent
 * @method static Builder|Menu ofSearch($params)
 */
class Menu extends Model
{
    use SoftDeletes, PermissibleTrait;

    /**
     * 菜单类型 路由
     */
    const TYPE_ROUTE = 'route';
    /**
     * 菜单类型 外链
     */
    const TYPE_LINK = 'link';
    /**
     * 菜单类型 内嵌
     */
    const TYPE_IFRAME = 'iframe';

    /**
     * type_label
     */
    const TYPE_LABEL = [
        self::TYPE_ROUTE => '路由',
        self::TYPE_LINK => '外链',
        self::TYPE_IFRAME => '内嵌',
    ];

    /**
     * @var string[]
     */
    protected $fillable = [
        'pid', 'name', 'label', 'url', 'type', 'icon', 'sort'
    ];

    /**
     * @var string[]
     */
    protected $hidden = [
        'deleted_at', 'updated_at',
    ];

    /**
     * @var string[]
     */
    protected $appends = [
        'type_label', 'alias',
    ];

    /**
     * @var string[]
     */
    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    /**
     * alias
     * @return string
     */
    public function getAliasAttribute(): string
    {
        return $this->name;
    }

    /**
     * type_label
     * @return string
     */
    public function getTypeLabelAttribute(): string
    {
        return self::TYPE_LABEL[$this->type] ?? '';
    }

    /**
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
}
