<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Resources\ApiResource;
use Illuminate\Http\Request;

class PersonalController extends Controller
{
    public function info(Request $request): ApiResource
    {
        $user = $request->user();
        $user->roles = ['Administrator'];
        return ApiResource::make($user);
    }

    protected function getConfigs()
    {
        return [

        ];
    }

}
