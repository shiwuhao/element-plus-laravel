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
 * @property int $sort 排序
 * @property-read \Illuminate\Database\Eloquent\Collection|Menu[] $children
 * @property-read int|null $children_count
 * @property-read string $type_label
 * @method static Builder|Menu ofParent()
 * @method static \Illuminate\Database\Query\Builder|Menu onlyTrashed()
 * @method static Builder|Menu whereSort($value)
 * @method static \Illuminate\Database\Query\Builder|Menu withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Menu withoutTrashed()
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
        'type_label', 'alias', 'meta',
    ];

    /**
     * @var string[]
     */
    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    /**
     * children
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function children(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Menu::class, 'pid', 'id');
    }

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
     * meta
     * @return \string[][]
     */
    public function getMetaAttribute(): array
    {
        return ['meta' => [
            'title' => $this->label,
            'icon' => $this->icon,
            'sort' => $this->sort,
        ]];
    }

    /**
     * @param Builder $builder
     * @return Builder
     */
    public function scopeOfParent(Builder $builder): Builder
    {
        return $builder->where('pid', 0);
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
