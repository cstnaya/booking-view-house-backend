<?php

namespace App\Http\Presenters;

use App\Http\Repositories\CityRepository;
use App\Http\Repositories\HouseTypeRepository;

class HouseInfoPresenter
{
    private $CityRepository;
    private $HouseTypeRepository;

    public function __construct(
        CityRepository $CityRepository,
        HouseTypeRepository $HouseTypeRepository
    ) {
        $this->CityRepository = $CityRepository;
        $this->HouseTypeRepository = $HouseTypeRepository;
    }

    public function showInfos()
    {
        $cities = $this->CityRepository->show();
        $houseTypes = $this->HouseTypeRepository->show();

        return ['cities' => $cities, 'house_types' => $houseTypes];
    }
}
