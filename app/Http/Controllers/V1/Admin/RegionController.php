<?php

namespace App\Http\Controllers\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\V1\ApiController;
use App\Models\Region;
use App\Traits\DeleteData;
use Illuminate\Http\Request;

class RegionController extends ApiController
{

    public function index()
    {
        return $this->responseSuccess(Region::getList());
    }
//    public function create()
//    {
//        //
//    }

    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        return $this->responseSuccess(Region::query()->create($request->all()));
    }
    public function show($id): \Illuminate\Http\JsonResponse
    {
        $response = Region::getRegionBanners($id);
        return $this->responseSuccess($response);
    }

//    public function edit(Region $region)
//    {
//        //
//    }

    public function update(Request $request, Region $region): \Illuminate\Http\JsonResponse
    {
        return $this->responseUpdate($region->update($request->all()));
    }

    public function destroy(Region $region): \Illuminate\Http\JsonResponse
    {
        return $this->responseDelete(DeleteData::deletedData($region));
    }

}
