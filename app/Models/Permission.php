<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Permission
 *
 * @property int $id
 * @property int $pid
 * @property string $name 唯一标识
 * @property string $title 显示名称
 * @property string $method 请求方式
 * @property string $url url
 * @property string $remark 备注
 * @property \datetime|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|Permission[] $children
 * @property-read int|null $children_count
 * @method static Builder|Permission newModelQuery()
 * @method static Builder|Permission newQuery()
 * @method static Builder|Permission ofParent()
 * @method static Builder|Permission ofSearch($params = [])
 * @method static Builder|Permission query()
 * @method static Builder|Permission whereCreatedAt($value)
 * @method static Builder|Permission whereId($value)
 * @method static Builder|Permission whereMethod($value)
 * @method static Builder|Permission whereName($value)
 * @method static Builder|Permission wherePid($value)
 * @method static Builder|Permission whereRemark($value)
 * @method static Builder|Permission whereTitle($value)
 * @method static Builder|Permission whereUpdatedAt($value)
 * @method static Builder|Permission whereUrl($value)
 * @mixin \Eloquent
 */
class Permission extends Model
{
    use HasFactory;

    /**
     * @var string[]
     */
    protected $fillable = [
        'name', 'title', 'url', 'method',
    ];

    /**
     * @var string[]
     */
    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
    ];

    /**
     * @var string[]
     */
    protected $hidden = [
        'updated_at'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function children()
    {
        return $this->hasMany(Permission::class, 'pid', 'id');
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
     * @param array $params
     * @return Builder
     */
    public function scopeOfSearch(Builder $builder, $params = []): Builder
    {
        if (!empty($params['name']) && $params['name']) {
            $builder->where('name', 'like', "{$params['name']}%");
        }
        if (!empty($params['url']) && $params['url']) {
            $builder->where('url', 'like', "{$params['url']}%");
        }
        if (!empty($params['method']) && $params['method']) {
            $builder->where('method', $params['method']);
        }

        return $builder;
    }
}
