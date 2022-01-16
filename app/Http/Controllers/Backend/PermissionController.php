<?php

namespace App\Http\Controllers\Backend;

use App\Exceptions\ApiException;
use App\Http\Controllers\Controller;
use App\Http\Resources\ApiResource;
use App\Models\Permission;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

/**
 *
 */
class PermissionController extends Controller
{
    protected $sortStep = 65536;

    /**
     * @param Request $request
     * @return AnonymousResourceCollection
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $permissions = Permission::ofSearch($request->all())->with('permissible')->oldest('sort')->oldest('id')->get();

        return ApiResource::collection($permissions);
    }

    /**
     * @param Request $request
     * @param Permission $permission
     * @return ApiResource
     */
    public function update(Request $request, Permission $permission): ApiResource
    {
        $dropPermission = Permission::find($request->get('drop_id'));//3
        $beforePermission = '';
        $afterPermission = '';

        if ($request->get('drop_type') == 'inner') {
            $permission->pid = $dropPermission->id;
        } elseif ($request->get('drop_type') == 'before') {
            $beforePermission = Permission::wherePid($dropPermission->pid)->where('sort', '<', $dropPermission->sort)->latest('sort')->first(); // 5
            if ($beforePermission) { // 存在两个之间
                $permission->sort = ($dropPermission->sort + $beforePermission->sort) / 2;
                $permission->pid = $beforePermission->pid;
            } else {
                $permission->sort = $dropPermission->sort / 2;
                $permission->pid = $dropPermission->pid;
            }

        } elseif ($request->get('drop_type') == 'after') {
            $afterPermission = Permission::wherePid($dropPermission->pid)->where('sort', '>', $dropPermission->sort)->oldest('sort')->first();
            if ($afterPermission) { // 存在两个之间
                $permission->sort = ($dropPermission->sort + $afterPermission->sort) / 2;
                $permission->pid = $afterPermission->pid;
            } else {
                $permission->sort = $dropPermission->sort + $this->sortStep;
                $permission->pid = $dropPermission->pid;
            }
        }

        if ($permission->sort == 0 || !is_int($permission->sort)) {
            throw new ApiException('请先初始化排序后在进行操作');
        }

        $permission->save();

        return ApiResource::make(['before' => $beforePermission, 'after' => $afterPermission]);
    }

    /**
     * 初始化排序
     * @return ApiResource
     */
    public function initSort(): ApiResource
    {
        Permission::oldest('sort')->oldest('id')->get()->each(function ($item, $key) {
            $item->sort = ($key + 1) * $this->sortStep;
            $item->save();
        });

        return ApiResource::make([]);
    }
}
