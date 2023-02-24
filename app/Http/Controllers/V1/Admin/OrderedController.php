<?php

namespace App\Http\Controllers\V1\Admin;

use App\Http\Controllers\V1\ApiController;
use App\Models\Order;
use App\Traits\DeleteData;
use App\Traits\Paginator;
use Illuminate\Http\Request;

class OrderedController extends ApiController
{
    public function index(): \Illuminate\Http\JsonResponse
    {
        $count_pagination = \request('count_pg');
        if(empty($count_pagination)){
            $count_pagination = 2;
        }
        return $this->responseSuccess(Paginator::pagination(Order::getList($count_pagination)));
    }

//    public function create()
//    {
//        //
//    }

    /**
     * @throws \Exception
     */
    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        $data = Order::storeSum($request->all());
        return $this->responseSuccess(Order::query()->create($data));
    }

    public function show(Order $order): \Illuminate\Http\JsonResponse
    {
        return $this->responseSuccess($order);
    }

//    public function edit(Order $order)
//    {
//        //
//    }
    public function update(Request $request, Order $order): \Illuminate\Http\JsonResponse
    {
        return $this->responseUpdate($order->update($request->all()));
    }

    public function destroy(Order $order): \Illuminate\Http\JsonResponse
    {
        return $this->responseDelete(DeleteData::deletedData($order));
    }
}
