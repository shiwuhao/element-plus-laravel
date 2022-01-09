<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Resources\ApiResource;
use App\Models\User;
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
    public function info(Request $request)
    {
        $user = $request->user();
        $user->roles = ['Administrator'];
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
            $roles = $user->roles()->get(['id', 'name', 'label', 'desc']);
            $permissions = $user->permissions();

            return $permissions->groupBy('permissible_type')->map(function ($item) {
                return $item->pluck('permissible');
            })->put('roles', $roles)->all();
        });

        return ApiResource::make($response);
    }
}
