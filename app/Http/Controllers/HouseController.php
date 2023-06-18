<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;

use App\Http\Concretes\HouseConcrete;
use App\Http\Services\HouseService;
use App\Http\Services\HouseReservationService;
use App\Http\Presenters\HouseInfoPresenter;

class HouseController extends Controller
{
    private $HouseService;
    private $HouseConcrete;
    private $HouseInfoPresenter;
    private $HouseReservationService;

    public function __construct(
        HouseService $HouseService,
        HouseConcrete $HouseConcrete,
        HouseInfoPresenter $HouseInfoPresenter,
        HouseReservationService $HouseReservationService
    ) {
        $this->HouseService = $HouseService;
        $this->HouseConcrete = $HouseConcrete;
        $this->HouseInfoPresenter = $HouseInfoPresenter;
        $this->HouseReservationService = $HouseReservationService;
    }

    /**
     * Display search result by filter
     */
    public function index(Request $request)
    {
        $query = $request->query();

        // others=pet,cook,stop,parking,elevator,...
        if (isset($query['others'])) {
            $lists = explode(',', $query['others']);

            foreach ($lists as $item) {
                $query[$item] = true;
            }
        }

        $res = $this->HouseService->showAllItems($query);

        return response()->json(['success' => true, 'data' => $res]);
    }

    /**
     * Show all house owned by a owner.
     */
    public function indexByOwnerId(string $id)
    {
        $res = $this->HouseService->showItemsByOwnerId($id);

        return response()->json(['success' => true, 'data' => $res]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // TODO: add validator: data and reject not owner
        try {
            DB::beginTransaction();

            // store house metadata 
            $data = $request->except(['reservations']);
            $res = $this->HouseService->insertItem($data);

            // store house reservations
            $reservs = $request->reservations;
            if ($reservs) {
                $id = $res->id;

                $reserv_datas = array_map(function ($time) use ($id) {
                    return ['house_id' => $id, 'time' => $time];
                }, $reservs);

                $reserv_res = $this->HouseReservationService->insertItems($reserv_datas);
            }

            DB::commit();
            return response()->json(['success' => true, 'data' => $res]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(["error" => $e], 400);
        }
    }

    /**
     * Display the specified house.
     */
    public function show(string $id)
    {
        $res = $this->HouseConcrete->showHouseDetailByHouseId($id);

        return response()->json(['success' => true, 'data' => $res]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // TODO: add validator, 403 if user is not owner

        $data = $request->all();

        $this->HouseService->updateItem($id, $data);

        return response()->json(['success' => true]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // TODO: add validator, 403 if user is not owner

        $this->HouseService->destroyItem($id);

        return response()->json(['success' => true]);
    }

    /**
     * Show info of a house, like: cities list, city_dists, house_types, ...
     */
    public function info()
    {
        $res = $this->HouseInfoPresenter->showInfos();

        return response()->json(['success' => true, 'data' => $res]);
    }
}
