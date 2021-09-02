<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name', 'title', 'remark', 'status'
    ];

    protected $appends = [
        'status_label'
    ];

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
     * @param Builder $builder
     * @param array $params
     * @return Builder
     */
    public function scopeOfSearch(Builder $builder, $params = []): Builder
    {
        if (!empty($params['title']) && $params['title']) {
            $builder->where('title', 'like', "{$params['title']}%");
        }

        if (!empty($params['name']) && $params['name']) {
            $builder->where('name', 'like', "{$params['name']}%");
        }

        return $builder;
    }
}
