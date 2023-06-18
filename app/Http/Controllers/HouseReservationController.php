<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\HouseReservationService;

use Carbon\Carbon;

class HouseReservationController extends Controller
{
    private $HouseReservationService;

    public function __construct(
        HouseReservationService $HouseReservationService
    ) {
        $this->HouseReservationService = $HouseReservationService;
    }

    // 顯示該日所有預約時間，包含已被預約跟還沒預約的
    public function showAllReservationsByHouseIdAndDate(Request $request)
    {
        $house_id = $request->query('house');
        $date = $request->query('date');

        $res = $this->HouseReservationService->showTimesByHouseIdAndDate($house_id, $date);

        return response()->json(['success' => true, 'data' => $res]);
    }

    /**
     * @param request request
     *     includes: house_id, times for reservation.
     * @return collect
     */
    public function store(Request $request)
    {
        $insertDatas = [];

        $data = $request->all();
        foreach ($data['times'] as $time) {
            $insertDatas[] = [
                'house_id' => $data['house_id'],
                'time' => Carbon::parse($time),
            ];
        }

        $res = $this->HouseReservationService->insertItems($insertDatas);

        return response()->json(['success' => true, 'data' => $res]);
    }

    /**
     * delete multiple timezones
     * @param array ids: [1, 2, 3, ...]
     */
    public function destroy(Request $request)
    {
        $ids = $request->delete;

        $this->HouseReservationService->destroyItems($ids);

        return response()->json(['success' => true]);
    }
}
