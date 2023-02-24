<?php

namespace App\Models;

use App\Enums\BannerTypeEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\UploadImage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class Banner extends Model
{
    use HasFactory, UploadImage;
    public const STORAGE_PHOTO_PATH = 'public/advertisement';


    protected $fillable = ['type', 'description', 'long','lat', 'sum', 'district_id','image','phone'];
    public static function getList($count_pagination): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        Order::finishDate();
        $storagePhotoPath = env("APP_URL").Storage::url(self::STORAGE_PHOTO_PATH);
        return self::query()->select('id','type','description', 'long', 'lat', 'phone','sum','district_id',
            DB::raw('CONCAT("'.$storagePhotoPath.'/", image) as image'))
            ->where('deleted',1)
            ->where('free',1)
            ->paginate($count_pagination);
    }

    protected $casts = [
        'status' => BannerTypeEnum::class
    ];
}
