<?php

namespace App\Http\Controllers\V1\Admin;

use App\Http\Controllers\V1\ApiController;
use App\Models\SeasonDiscount;
use App\Traits\DeleteData;
use Illuminate\Http\Request;

class SeasonDiscountController extends ApiController
{
    public function index(): \Illuminate\Http\JsonResponse
    {
        return $this->responseSuccess(SeasonDiscount::getList());
    }

//    public function create()
//    {
//        //
//    }

    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        return $this->responseSuccess(SeasonDiscount::query()->create($request->all()));
    }

    public function show(SeasonDiscount $season_discount): \Illuminate\Http\JsonResponse
    {
        return $this->responseSuccess($season_discount);
    }

//    public function edit(SeasonDiscount $season_discount)
//    {
//        //
//    }
    public function update(Request $request, SeasonDiscount $season_discount): \Illuminate\Http\JsonResponse
    {
        return $this->responseUpdate($season_discount->update($request->all()));
    }

    public function destroy(SeasonDiscount $season_discount): \Illuminate\Http\JsonResponse
    {
        return $this->responseDelete(DeleteData::deletedData($season_discount));
    }
}
