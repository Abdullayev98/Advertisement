<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    use HasFactory;
    protected $fillable = ['name','region_id'];
    public function banners(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Banner::class);
    }public function regions(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Banner::class);
    }

    public static function getDistrictBanners($id): Model|\Illuminate\Database\Eloquent\Builder
    {
        return self::query()->select([
            'id',
            'name',])
            ->with(['banners'=>function($q){
                    $q->select('type','description','free','long','lat','sum','district_id');
                }],
            [
                'regions'=>function($q){
                    $q->select('id','name');
                }
            ])
            ->where('id', $id)
            ->firstOrFail();
    }
    public static function getList(): array|\Illuminate\Database\Eloquent\Collection
    {
        return self::query()->select(['id','name'])
            ->where('deleted', 1)
            ->orderBy('name')->get();
    }
}
