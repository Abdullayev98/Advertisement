<?php

namespace App\Traits;


use JetBrains\PhpStorm\ArrayShape;

trait Paginator
{
    #[ArrayShape(['current_page' => "", 'from' => "", 'last_page' => "", 'per_page' => "", 'to' => "", 'total' => "", 'data' => ""])] public static function pagination($pagination): array
    {
        return [
            'current_page' => $pagination->currentPage(),
            'from' => $pagination->firstItem(),
            'last_page' => $pagination->lastPage(),
            'per_page' => $pagination->perPage(),
            'to' => $pagination->lastItem(),
            'total' => $pagination->total(),
            'data' => $pagination->items(),
        ];
    }
}
