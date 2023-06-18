<?php

namespace App\Http\Repositories;

use Illuminate\Support\Facades\DB;
use App\Models\Order;

use Exception;

class OrderRepository
{
    /**
     * Show customers orders
     */
    public function showAllOrdersById(string $id)
    {
        return DB::table('orders')->where('customer_id', $id)
            ->join('house_reservations', 'house_reservations.id', '=', 'reservation_id')
            ->join('houses', 'houses.id', '=', 'house_id')
            ->select('orders.*', 'houses.name', 'time')
            ->orderBy('date', 'asc')
            ->get();
    }

    public function insertOrder(array $data)
    {
        try {
            DB::beginTransaction();

            $res = Order::create($data)->lockForUpdate();

            DB::commit();

            return $res;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function destroyByIds(array $ids)
    {
        return Order::whereIn('id', $ids)->delete();
    }
}
