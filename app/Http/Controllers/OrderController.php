<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\OrderService;

class OrderController extends Controller
{
    private $OrderService;

    public function __construct(OrderService $OrderService)
    {
        $this->OrderService = $OrderService;
    }

    /**
     * Show someone's all orders.
     * @param int $id
     */
    public function index(string $id)
    {
        $res = $this->OrderService->showAllItemsById($id);

        return response()->json(['success' => true, 'data' => $res]);
    }

    /**
     * Create a new order. 
     */
    public function store(Request $request)
    {
        // add lockForUpdate => somebody else can read, but no one can write
        $data = $request->all();

        $res = $this->OrderService->insertItem($data);

        return response()->json(['success' => true, 'data' => $res]);
    }

    /**
     * Destroy multiple orders
     */
    public function destroy(Request $request)
    {
        $ids = $request->delete;

        $res = $this->OrderService->destroyItems($ids);

        return response()->json(['success' => true]);
    }
}
