<?php

namespace App\Http\Services;

use App\Http\Repositories\HouseReservationRepository;

class HouseReservationService
{
    private $HouseReservationRepository;


    public function __construct(HouseReservationRepository $HouseReservationRepository)
    {
        $this->HouseReservationRepository = $HouseReservationRepository;
    }

    /**
     * Show all reservation times of a house.
     * @param string id: house_id
     */
    public function showAllItems(string $id)
    {
        return $this->HouseReservationRepository->showAllDatabyHouseId($id);
    }

    /**
     * Show reservation times of a house in specific date.
     * @param string house_id
     * @param string date
     */
    public function showTimesByHouseIdAndDate(string $house_id, string $date)
    {
        return $this->HouseReservationRepository->showTimesByHouseIdAndDate($house_id, $date);
    }

    public function insertItems(array $data)
    {
        return $this->HouseReservationRepository
            ->insertMultipleReservationData($data);
    }

    public function destroyItems(array $ids)
    {
        return $this->HouseReservationRepository->destroyByIds($ids);
    }
}
