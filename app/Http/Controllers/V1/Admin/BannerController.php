<?php

namespace App\Http\Controllers\V1\Admin;

use App\Http\Controllers\V1\ApiController;
use App\Models\Banner;
use App\Traits\Paginator;
use Illuminate\Http\Request;

class BannerController extends ApiController
{

    public function index()
    {
        $count_pagination = \request('count_pg');
        if(empty($count_pagination)){
            $count_pagination = 2;
        }
        return $this->responseSuccess(Paginator::pagination(Banner::getList($count_pagination)));
    }

//    public function create()
//    {
//
//    }

    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        $data = $request->all();
        if ($request->hasFile('image')) {
            $data['image'] = Banner::uploadPhoto($request->image, Banner::STORAGE_PHOTO_PATH);
        }
        return $this->responseSuccess(Banner::query()->create($data));
    }

    public function show(Banner $banner): \Illuminate\Http\JsonResponse
    {
        return $this->responseSuccess($banner);
    }

//    public function edit(Banner $banner)
//    {
//        //
//    }

    public function update(Request $request, Banner $banner): \Illuminate\Http\JsonResponse
    {
        if($request->hasFile('image')) {
            $uploadFile = $request->file('image');
            $uploadedPhoto = Banner::uploadPhoto($uploadFile, Banner::STORAGE_PHOTO_PATH, $banner->image);
        }
        $data = isset($uploadedPhoto)?array_merge($request->all(), ['image' => $uploadedPhoto]):$request->all();
        return $this->responseUpdate($banner->update($data));
    }

    public function destroy(Banner $banner): \Illuminate\Http\JsonResponse
    {
        if (isset($banner->image)){
            Banner::deletePhotos($banner->image, Banner::STORAGE_PHOTO_PATH);
        }
        return $this->responseDelete($banner->delete());
    }
}
