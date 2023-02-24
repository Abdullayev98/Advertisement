<?php

namespace App\Models;

use App\Http\Controllers\V1\ApiController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    use HasFactory;
    protected $fillable = ['name'];

    public function districts(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(District::class);
    }

    public static function getRegionBanners($id): Model|\Illuminate\Database\Eloquent\Builder
    {
        return self::query()->select([
            'id',
            'name',])
            ->with(['districts'=>function($query) {
                    $query->select('id','name', 'region_id')->with(['banners'=>function($q){
                        $q->select('type','description','free','long','lat','sum','district_id');
                    }]);
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
