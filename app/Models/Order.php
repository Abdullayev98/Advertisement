<?php

namespace App\Models;

use App\Traits\DeleteData;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DateTime;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class Order extends Model
{
    use HasFactory;
    protected $fillable = ['start_date','end_date','sum', 'season_discount_id', 'banner_id','daily_discount_id'];

    public static function getList($count_pagination): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        self::finishDate();
        return self::query()->select('start_date','end_date','sum', 'season_discount_id', 'banner_id','daily_discount_id')
            ->where('deleted',1)
            ->paginate($count_pagination);
    }
// agar muddati tugagan bo'lsa uni banner jadvaliga qo'sh va order jadvaldan o'chir
    public static function finishDate()
    {
        $date = Carbon::now();
        $data = self::query()->select('id','banner_id')
            ->whereDate('end_date','<=',$date)
            ->get();
        foreach ($data as $item){
            $banner= Banner::query()->where('id',$item->banner_id)->first();
            $banner->free = true;
            $banner->save();
            $order = self::query()->findOrFail($item->id);
            DeleteData::deletedData($order);
        }
    }

    /**
     * @throws Exception
     */

    // find how many difference between startDate and endDate
    public static function orderedDaysCount($data): string
    {
        $start_date = new DateTime($data['start_date']);
        $end_date = new DateTime($data['end_date']);
        $interval = $start_date->diff($end_date);
        return $interval->format('%a');
    }
    public static function orderedSum($data): string
    {
        $banner= Banner::query()->where('id',$data['banner_id'])->first();
        $banner->free = false;
        $banner->save();
        return Banner::query()->select('sum')->where('id',$data['banner_id'])->sum('sum');
    }
    /**
     * @throws Exception
     */
    // get percent daily discount (as 0.12) and its id
    public static function Daily_Discount($data)
    {
        // banner's cost
        $days = self::orderedDaysCount($data);

        // calculate sum with daily_discount percent
        $daily_discounts = DailyDiscount::query()->orderByDesc('count_days')->get();
        foreach ($daily_discounts as $item) {
            if ($days >= $item->count_days) {
                $data['daily_discount_id'] = $item->id;
                $data['daily_percent'] = $item->percent / 100;
                return $data;
            }
        }
        $data['daily_discount_id'] = 0;
        return $data;
    }
    // get percent season discount (as 0.12) and its id
    public static function Season_Discount($data)
    {
        $date = Carbon::now();
        $seasonDiscount = SeasonDiscount::query()
            ->whereRaw('"'.$date.'" between `start_date` and `end_date`')
            ->first();

        if (isset($seasonDiscount)) {
            $data['season_discount_id'] = $seasonDiscount->id;
            $data['season_percent'] = $seasonDiscount->percent / 100;
            return $data;
        }
        $data['season_discount_id'] = 0;
        return $data;
    }

    /**
     * @throws Exception
     */
    // array merge $data
    public static function commonPercent($data): array
    {
        $daily_discount = self::Daily_Discount($data);
        $season_discount = self::Season_Discount($data);
        return array_merge((array)$daily_discount, (array)$season_discount);
    }

    /**
     * @throws Exception
     */
    public static function storeSum ($data): array
    {
        $data = self::commonPercent($data);
        $sum = self::orderedSum($data);
        if(isset($data['daily_percent']) && isset($data['season_percent'])){
            $sum = $sum - $sum*($data['daily_percent'] + $data['season_percent']);
        }elseif (isset($data['daily_percent'])){
            $sum = $sum - $sum*$data['daily_percent'];
        }elseif (isset($data['season_percent'])){
            $sum = $sum - $sum*$data['season_percent'];
        }
        unset($data['daily_percent'],$data['season_percent']);
        $data['sum'] = $sum;
        return $data;
    }
}
