<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Resources\ApiResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class UserController extends Controller
{

    /**
     * @param Request $request
     * @return AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        $users = User::ofSearch($request->all())->latest('id')->paginate();

        return ApiResource::collection($users);
    }

    /**
     * @param Request $request
     * @return ApiResource
     */
    public function store(Request $request): ApiResource
    {
        $user = new User($request->all());
        $user->password = bcrypt($request->password);
        $user->save();

        return ApiResource::make($user);
    }

    /**
     * @param User $user
     * @return ApiResource
     */
    public function show(User $user): ApiResource
    {
        return ApiResource::make($user);
    }

    /**
     * @param Request $request
     * @param User $user
     * @return ApiResource
     */
    public function update(Request $request, User $user): ApiResource
    {
        $user->fill($request->all());
        $user->save();

        return ApiResource::make($user);
    }

    /**
     * @param $id
     * @return ApiResource
     */
    public function destroy($id): ApiResource
    {
        $user = User::withTrashed()->find($id);
        if (!$user->trashed()) {
            $user->delete();
        }

        return ApiResource::make($user);
    }
}
