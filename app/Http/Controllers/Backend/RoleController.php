<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Resources\ApiResource;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class RoleController extends Controller
{

    /**
     * @param Request $request
     * @return AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        $roles = Role::ofSearch($request->all())->latest('id')->paginate();

        return ApiResource::collection($roles);
    }

    /**
     * @param Request $request
     * @return ApiResource
     */
    public function store(Request $request): ApiResource
    {
        $role = new Role($request->all());
        $role->save();

        return ApiResource::make($role);
    }

    /**
     * @param Role $role
     * @return ApiResource
     */
    public function show(Role $role): ApiResource
    {
        return ApiResource::make($role);
    }

    /**
     * @param Request $request
     * @param Role $role
     * @return ApiResource
     */
    public function update(Request $request, Role $role): ApiResource
    {
        $role->fill($request->all());
        $role->save();

        return ApiResource::make($role);
    }

    /**
     * @param $id
     * @return ApiResource
     */
    public function destroy($id): ApiResource
    {
        $role = Role::withTrashed()->find($id);
        if (!$role->trashed()) {
            $role->delete();
        }

        return ApiResource::make($role);
    }
}