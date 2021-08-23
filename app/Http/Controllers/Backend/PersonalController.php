<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Resources\ApiResource;
use Illuminate\Http\Request;

class PersonalController extends Controller
{
    public function user(Request $request): ApiResource
    {
        return ApiResource::make($request->user());
    }

    protected function getConfigs()
    {
        return [

        ];
    }

}
