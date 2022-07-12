<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use App\Models\Status;

class StockService
{
    public function stockStatus(Array $params = [])
    {
        $statuses = Cache::remember('product_status', 5, function () {
            return Status::select('id', 'name')
            ->where(['type' => 'product'])
            ->get();
        });

        if (!empty($params['keyBy'])) {
            $statuses = $statuses->keyBy($params['keyBy']);
        }

        return $statuses->toArray();
    }

    public function maxPrice()
    {
        $length = 19;
        $decimal = config('constant.decimals');

        $prefix = str_pad("", $length-$decimal, "9", STR_PAD_RIGHT);
        return str_pad($prefix, $length, "0", STR_PAD_RIGHT);
    }
}
