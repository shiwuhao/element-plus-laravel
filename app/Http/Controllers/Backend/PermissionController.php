<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Resources\ApiResource;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

/**
 *
 */
class PermissionController extends Controller
{
    /**
     * @param Request $request
     * @return AnonymousResourceCollection
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $permissions = Permission::ofSearch($request->all())->with('permissible')->get();

        return ApiResource::collection($permissions);
    }

    /**
     * @param Request $request
     * @param Permission $permission
     * @return ApiResource
     */
    public function update(Request $request, Permission $permission): ApiResource
    {
        $dropPermission = Permission::find($request->get('drop_id'));

        $permission->pid = $request->get('drop_type') == 'inner' ? $dropPermission->id : $dropPermission->pid;
        $permission->save();

        return ApiResource::make($permission);
    }
}
