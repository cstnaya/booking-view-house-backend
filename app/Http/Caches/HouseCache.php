<?php

namespace App\Http\Caches;

use Illuminate\Support\Facades\Cache;
use App\Http\Caches\HouseNullObject;
use App\Models\House;

class HouseCache
{
    public function getHouseCache(string $id)
    {
        return Cache::get("house:$id");
    }

    public function putHouseCache($house)
    {
        Cache::put("house:$house->id", $house, now()->addDay());
    }

    public function clearHouseCache(string $id)
    {
        Cache::forget("house:$id");
    }

    public function putNullObject(string $id)
    {
        Cache::put("house:$id", new HouseNullObject());
    }
}
