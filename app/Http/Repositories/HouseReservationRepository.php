<?php

namespace App\Http\Repositories;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Models\HouseReservation;

class HouseReservationRepository
{
    public function showAllDatabyHouseId(string $id)
    {
        return HouseReservation::where('house_id', $id)->get();
    }

    public function insertMultipleReservationData(array $data)
    {
        return HouseReservation::insert($data);
    }

    public function destroyByIds(array $ids)
    {
        return HouseReservation::whereIn('id', $ids)->delete();
    }

    /**
     * @param string house_id
     * @param string date
     */
    public function showTimesByHouseIdAndDate(string $house_id, string $date)
    {
        $reserves = DB::select(
            'select reserv.*, (orders.id is not null) as has_ordered
             from house_reservations reserv
             left join orders on reserv.id = orders.reservation_id
             and date = ?
             where house_id = ?
             order by time asc
            ',
            [$date, $house_id]
        );

        return $reserves;
    }
}
