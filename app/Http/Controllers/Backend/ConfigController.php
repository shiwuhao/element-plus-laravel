<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Resources\ApiResource;
use App\Models\Config;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ConfigController extends Controller
{

    /**
     * @param Request $request
     * @return AnonymousResourceCollection
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $configs = Config::ofSearch($request->all())->latest('id')->paginate();

        return ApiResource::collection($configs);
    }

    /**
     * @param Request $request
     * @return ApiResource
     */
    public function store(Request $request): ApiResource
    {
        $config = new Config($request->all());
        $config->save();

        return ApiResource::make($config);
    }

    /**
     * @param Config $config
     * @return ApiResource
     */
    public function show(Config $config): ApiResource
    {
        sleep(1);
        return ApiResource::make($config);
    }

    /**
     * @param Request $request
     * @param Config $config
     * @return ApiResource
     */
    public function update(Request $request, Config $config): ApiResource
    {
        $config->fill($request->all());
        $config->save();

        return ApiResource::make($config);
    }

    /**
     * @param $id
     * @return ApiResource
     */
    public function destroy($id): ApiResource
    {
        $config = Config::withTrashed()->find($id);
        if (!$config->trashed()) {
            $config->delete();
        }

        return ApiResource::make($config);
    }

    /**
     * 获取分组下配置数据
     * @param Request $request
     * @return AnonymousResourceCollection
     */
    public function group(Request $request): AnonymousResourceCollection
    {
        $group = $request->get('group') ?? 'base';

        $configs = Config::ofGroup($group)->latest('sort')->latest('id')->get();

        return ApiResource::collection($configs);
    }

    /**
     * 更新分组下配置数据
     * @param Request $request
     * @return ApiResource
     */
    public function groupUpdate(Request $request): ApiResource
    {
        foreach ($request->all() as $name => $value) {
            Config::where('name', $name)->update(['value' => $value]);
        }

        return ApiResource::make();
    }

    /**
     * @return ApiResource
     */
    public function configItems(): ApiResource
    {
        $configs = Config::all()->pluck('parse_value', 'name')->merge([
            'groups' => $this->toDeepArray(Config::GROUP_LABEL),
            'types' => $this->toDeepArray(Config::TYPE_LABEL),
            'components' => $this->toDeepArray(Config::COMPONENT_LABEL),
        ]);

        return ApiResource::make($configs);
    }

    /**
     * 一维数组转二维
     * @param array $array
     * @return array
     */
    protected function toDeepArray(array $array = []): array
    {
        $data = [];
        foreach ($array as $key => $value) {
            $data[] = ['value' => $key, 'label' => $value];
        }
        return $data;
    }
}
