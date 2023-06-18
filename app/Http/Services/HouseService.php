<?php

namespace App\Http\Services;

use App\Http\Repositories\HouseRepository;
use App\Http\Services\Service;

class HouseService implements Service
{
    private $HouseRepository;

    public function __construct(HouseRepository $HouseRepository)
    {
        $this->HouseRepository = $HouseRepository;
    }

    /**
     * Show query results by filter.
     * @param array query
     * @return collect
     */
    public function showAllItems(array $query)
    {
        return $this->HouseRepository->getHousesByQuery($query);
    }

    /**
     * Show all houses owned by one owner.
     * @param string id
     * @return collect
     */
    public function showItemsByOwnerId(string $id)
    {
        return $this->HouseRepository->getHousesByOwnerId($id);
    }

    public function showItem(string $id)
    {
        return $this->HouseRepository->getHouseById($id);
    }

    public function insertItem(array $data)
    {
        return $this->HouseRepository->insertHouseData($data);
    }

    public function updateItem(string $id, array $data)
    {
        return $this->HouseRepository->updateHouseById($id, $data);
    }

    public function destroyItem(string $id)
    {
        return $this->HouseRepository->destroyById($id);
    }
}
