<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Resources\ApiResource;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

/**
 * Class PersonalController
 * @package App\Http\Controllers\Backend
 */
class PersonalController extends Controller
{
    /**
     * 个人信息
     * @param Request $request
     * @return ApiResource
     */
    public function info(Request $request): ApiResource
    {
        $user = $request->user();

        return ApiResource::make($user);
    }

    /**
     * 菜单、权限节点
     * @param Request $request
     * @return ApiResource
     */
    public function permissions(Request $request): ApiResource
    {
        $user = $request->user();

        $key = 'userPermissions:' . $user->id;
        $response = Cache::remember($key, 10, function () use ($user) {
            $permissions = $user->isAdministrator() ? Permission::all() : $user->permissions();
            return $permissions->groupBy('permissible_type')->map(function ($item) {
                return $item->pluck('permissible');
            })->put('roles', $user->roles);
        });

        return ApiResource::make($response);
    }
}
