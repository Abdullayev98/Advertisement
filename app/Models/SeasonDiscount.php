<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SeasonDiscount extends Model
{
    use HasFactory;
    protected $fillable = ['description','percent', 'start_date','end_date'];
    public static function getList(): \Illuminate\Database\Eloquent\Collection|array
    {
        return self::query()
            ->where('deleted',1)
            ->get();
    }
}
