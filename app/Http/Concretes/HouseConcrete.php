<?php

namespace App\Http\Concretes;

use App\Http\Services\HouseService;
use App\Http\Services\HouseReservationService;

class HouseConcrete
{
    private $HouseService;
    private $HouseReservationService;

    public function __construct(HouseService $HouseService, HouseReservationService $HouseReservationService)
    {
        $this->HouseService = $HouseService;
        $this->HouseReservationService = $HouseReservationService;
    }

    /**
     * Show house metadata and its reservation info.
     */
    public function showHouseDetailByHouseId(string $id)
    {
        $house = $this->HouseService->showItem($id);

        // house might be null
        if ($house) {
            $reservs = $this->HouseReservationService->showAllItems($id);
            $house->reservations = $reservs;
        }

        return $house;
    }
}
