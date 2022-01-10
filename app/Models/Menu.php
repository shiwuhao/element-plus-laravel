<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Shiwuhao\Rbac\Models\Traits\PermissibleTrait;

/**
 * App\Models\Action
 *
 * @property int $id
 * @property string $name 唯一标识
 * @property string $label 显示名称
 * @property string $method 请求方式
 * @property string $uri 请求路径
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read string $alias
 * @property-read \Shiwuhao\Rbac\Models\Permission|null $permission
 * @method static \Illuminate\Database\Eloquent\Builder|Action newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Action newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Action query()
 * @method static \Illuminate\Database\Eloquent\Builder|Action whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Action whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Action whereLabel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Action whereMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Action whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Action whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Action whereUri($value)
 * @mixin \Eloquent
 */
class Menu extends Model
{
    use PermissibleTrait;

    /**
     * @var string[]
     */
    protected $fillable = [
        'pid', 'name', 'label', 'url', 'type', 'icon'
    ];

    /**
     * @var string[]
     */
    protected $hidden = [
        'deleted_at'
    ];

    /**
     * @var string[]
     */
    protected $appends = [
        'alias'
    ];

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
}
