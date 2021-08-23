<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ConfigItem
 *
 * @property int $id
 * @property int $config_id 配置ID
 * @property int $pid
 * @property string $title 名称
 * @property string $code 代码
 * @property int $sort 排序
 * @property string|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|ConfigItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ConfigItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ConfigItem query()
 * @method static \Illuminate\Database\Eloquent\Builder|ConfigItem whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConfigItem whereConfigId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConfigItem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConfigItem whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConfigItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConfigItem wherePid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConfigItem whereSort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConfigItem whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConfigItem whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ConfigItem extends Model
{
    use HasFactory;
}
