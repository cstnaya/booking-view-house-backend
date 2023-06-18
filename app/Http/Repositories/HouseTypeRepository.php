<?php

namespace App\Http\Repositories;

use Illuminate\Support\Facades\DB;
use App\Models\HouseType;

class HouseTypeRepository
{
    public function show()
    {
        return HouseType::all();
    }
}
