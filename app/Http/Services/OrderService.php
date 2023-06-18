<?php

namespace App\Http\Services;

use App\Http\Repositories\OrderRepository;

class OrderService
{
    private $OrderRepository;

    public function __construct(OrderRepository $OrderRepository)
    {
        $this->OrderRepository = $OrderRepository;
    }

    public function showAllItemsById(string $id)
    {
        return $this->OrderRepository->showAllOrdersById($id);
    }

    public function insertItem(array $data)
    {
        return $this->OrderRepository
            ->insertOrder($data);
    }

    public function destroyItems(array $ids)
    {
        return $this->OrderRepository->destroyByIds($ids);
    }
}
