<?php

namespace App\Http\Repositories;

use App\Models\City;

class CityRepository
{
    public function show()
    {
        return City::select("*")->with('city_dists')->get();
    }
}
