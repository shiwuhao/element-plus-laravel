<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'title', 'url', 'method',
    ];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
    ];

    protected $hidden = [
        'updated_at'
    ];

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
