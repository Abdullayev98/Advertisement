<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailyDiscount extends Model
{
    use HasFactory;
    protected $table = "daily_discounts";
    protected $fillable = ['count_days', 'percent'];
    public static function getList(): \Illuminate\Database\Eloquent\Collection|array
    {
        return self::query()
            ->where('deleted',1)
            ->get();
    }
}
