<?php

namespace App\Http\Controllers\V1\Admin;

use App\Http\Controllers\V1\ApiController;
use App\Models\District;
use App\Traits\DeleteData;
use Illuminate\Http\Request;

class DistrictController extends ApiController
{

    public function index(): \Illuminate\Http\JsonResponse
    {
        return $this->responseSuccess(District::getList());
    }

//    public function create()
//    {
//        //
//    }

    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        return $this->responseSuccess(District::query()->create($request->all()));
    }

    public function show($id): \Illuminate\Http\JsonResponse
    {
        $response = District::getDistrictBanners($id);
        return $this->responseSuccess($response);
    }

//    public function edit(District $district)
//    {
//        //
//    }
    public function update(Request $request, District $district): \Illuminate\Http\JsonResponse
    {
        return $this->responseUpdate($district->update($request->all()));
    }

    public function destroy(District $district): \Illuminate\Http\JsonResponse
    {
        return $this->responseDelete(DeleteData::deletedData($district));
    }
}
