<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Config
 *
 * @property int $id
 * @property string $name 配置标识
 * @property string $title 配置名称
 * @property string $group 分组
 * @property string $type 类型
 * @property string $component 渲染组件
 * @property int $sort 排序
 * @property string|null $value 配置值
 * @property string|null $extra 扩展
 * @property string|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read string $component_label
 * @property-read string $type_label
 * @method static \Illuminate\Database\Eloquent\Builder|Config newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Config newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Config query()
 * @method static \Illuminate\Database\Eloquent\Builder|Config whereComponent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Config whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Config whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Config whereExtra($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Config whereGroup($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Config whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Config whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Config whereSort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Config whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Config whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Config whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Config whereValue($value)
 * @mixin \Eloquent
 * @method static Builder|Config ofSearch(array $params = [])
 * @method static Builder|Config ofGroup(string $group = '')
 * @method static \Illuminate\Database\Query\Builder|Config onlyTrashed()
 * @method static \Illuminate\Database\Query\Builder|Config withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Config withoutTrashed()
 */
class Config extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * @var string[]
     */
    protected $fillable = [
        'name',
        'title',
        'group',
        'type',
        'component',
        'sort',
        'value',
        'extra'
    ];

    /**
     * @var string[]
     */
    protected $hidden = [
        'deleted_at',
        'updated_at',
    ];

    /**
     * @var string[]
     */
    protected $appends = [
        'type_label',
        'group_label',
        'component_label',
        'parse_value',
        'parse_extra',
    ];

    /**
     * @var string[]
     */
    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i'
    ];

    // 配置分组
    const GROUP_BASIC = 'basic';
    const GROUP_SYSTEM = 'system';

    const GROUP_LABEL = [
        self::GROUP_BASIC => '基本配置',
        self::GROUP_SYSTEM => '系统配置',
    ];

    // 数据类型
    const TYPE_NUMBER = 'number';
    const TYPE_STRING = 'string';
    const TYPE_TEXT = 'text';
    const TYPE_ARRAY = 'array';
    const TYPE_ENUM = 'enum';

    const TYPE_LABEL = [
        self::TYPE_NUMBER => '数字',
        self::TYPE_STRING => '字符',
        self::TYPE_TEXT => '文本',
        self::TYPE_ARRAY => '数组',
        self::TYPE_ENUM => '枚举',
    ];

    // 组建类型
    const COMPONENT_INPUT = 'input';
    const COMPONENT_TEXTAREA = 'textarea';
    const COMPONENT_SELECT = 'select';
    const COMPONENT_TIME_PICKER = 'timePicker';
    const COMPONENT_DATE_PICKER = 'datePicker';
    const COMPONENT_DATETIME_PICKER = 'datetimePicker';
    const COMPONENT_UPLOAD = 'upload';
    const COMPONENT_COLOR_PICKER = 'colorPicker';

    const COMPONENT_LABEL = [
        self::COMPONENT_INPUT => 'Input输入框',
        self::COMPONENT_TEXTAREA => 'Textarea多行文本域',
        self::COMPONENT_SELECT => 'Select选择器',
        self::COMPONENT_TIME_PICKER => 'TimePicker时间选择器',
        self::COMPONENT_DATE_PICKER => 'DatePicker日期选择器',
        self::COMPONENT_DATETIME_PICKER => 'DatetimePicker日期时间选择器',
        self::COMPONENT_UPLOAD => 'Upload上传',
        self::COMPONENT_COLOR_PICKER => 'ColorPicker颜色选择器',
    ];

    /**
     * type_label
     * @return string
     */
    public function getTypeLabelAttribute(): string
    {
        return self::TYPE_LABEL[$this->type] ?? '';
    }

    /**
     * component_label
     * @return string
     */
    public function getComponentLabelAttribute(): string
    {
        return self::COMPONENT_LABEL[$this->component] ?? '';
    }

    /**
     * group_label
     * @return string
     */
    public function getGroupLabelAttribute(): string
    {
        return self::GROUP_LABEL[$this->group] ?? '';
    }

    /**
     * parse_value
     * @return array|array[]|false|string[]
     */
    public function getParseValueAttribute()
    {
        return $this->parseValue($this->type, $this->value);
    }

    /**
     * parse_extra
     * @return array|array[]|false|string[]
     */
    public function getParseExtraAttribute()
    {
        return $this->parseValue(self::TYPE_ARRAY, $this->extra);
    }

    /**
     * @param Builder $builder
     * @param string $group
     * @return Builder
     */
    public function scopeOfGroup(Builder $builder, string $group = ''): Builder
    {
        return $builder->where('group', $group);
    }

    /**
     * @param Builder $builder
     * @param array $params
     * @return Builder
     */
    public function scopeOfSearch(Builder $builder, array $params = []): Builder
    {
        if (!empty($params['title'])) {
            $builder->where('title', 'like', "{$params['title']}%");
        }

        if (!empty($params['name'])) {
            $builder->where('name', 'like', "{$params['name']}%");
        }
        return $builder;
    }

    /**
     * @param $type
     * @param $value
     * @return array|false|string[]
     */
    protected function parseValue($type, $value)
    {
        switch ($type) {
            case self::TYPE_ARRAY: // 数组
                $array = preg_split('/[,;\r\n]+/', trim($value, ",;\r\n"));
                if (strpos($value, ':')) {
                    $parseValue = array();
                    foreach ($array as $k => $val) {
                        list($value, $label) = explode(':', $val);
                        $parseValue[$value] = $label;
                    }
                } else {
                    $parseValue = $array;
                }
                break;
            default:
                $parseValue = $value;
        }
        return $parseValue;
    }
}
