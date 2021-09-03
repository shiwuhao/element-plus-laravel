<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Resources\ApiResource;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Artisan;

class PermissionController extends Controller
{

    /**
     * @param Request $request
     * @return AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        $permissions = Permission::ofSearch()->latest('id')->paginate();

        return ApiResource::collection($permissions);
    }

    /**
     * @param Request $request
     * @return ApiResource
     */
    public function store(Request $request): ApiResource
    {
        $permission = new Permission($request->all());
        $permission->save();

        return ApiResource::make($permission);
    }

    /**
     * @param Permission $permission
     * @return ApiResource
     */
    public function show(Permission $permission): ApiResource
    {
        return ApiResource::make($permission);
    }

    /**
     * @param Request $request
     * @param Permission $permission
     * @return ApiResource
     */
    public function update(Request $request, Permission $permission): ApiResource
    {
        $permission->fill($request->all());
        $permission->save();

        return ApiResource::make($permission);
    }

    /**
     * @param $id
     * @return ApiResource
     */
    public function destroy($id): ApiResource
    {
        $permission = Permission::find($id);
        if ($permission) {
            $permission->delete();
        }

        return ApiResource::make($permission);
    }

    /**
     * 自动生成权限节点
     * @return string
     */
    public function autoGenerate()
    {
        $path = 'backend';
        $exceptPath = ['backend/uploads'];
        Artisan::call('rbac:generate-permissions', [
            '--path' => $path,
            '--except-path' => join(',', $exceptPath)
        ]);

        return 'success';
    }
}
