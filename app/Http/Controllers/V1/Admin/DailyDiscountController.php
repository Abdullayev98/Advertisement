<?php

namespace App\Http\Controllers\V1\Admin;

use App\Http\Controllers\V1\ApiController;
use App\Models\DailyDiscount;
use App\Traits\DeleteData;
use Illuminate\Http\Request;

class DailyDiscountController extends ApiController
{

    public function index(): \Illuminate\Http\JsonResponse
    {
        return $this->responseSuccess(DailyDiscount::getList());
    }

//    public function create()
//    {
//        //
//    }

    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        return $this->responseSuccess(DailyDiscount::query()->create($request->all()));
    }

    public function show(DailyDiscount $daily_discount): \Illuminate\Http\JsonResponse
    {
        return $this->responseSuccess($daily_discount);
    }

//    public function edit(DailyDiscount $daily_discount)
//    {
//        //
//    }
    public function update(Request $request, DailyDiscount $daily_discount): \Illuminate\Http\JsonResponse
    {
        return $this->responseUpdate($daily_discount->update($request->all()));
    }

    public function destroy(DailyDiscount $daily_discount): \Illuminate\Http\JsonResponse
    {
        return $this->responseDelete(DeleteData::deletedData($daily_discount));
    }
}
