<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Services\NovaPoshtaService;

class NovaPoshtaController extends Controller
{
    protected $novaPoshtaService;

    public function __construct(NovaPoshtaService $novaPoshtaService)
    {
        $this->novaPoshtaService = $novaPoshtaService;
    }

    public function getCities()
    {
        $cities = $this->novaPoshtaService->getCities();
        return response()->json($cities);
    }

    public function getWarehouses($cityRef)
    {
        $warehouses = $this->novaPoshtaService->getWarehouses($cityRef);
        return response()->json($warehouses);
    }

    public function getDeliveryCost($cityRecipientRef)
    {
        $cost = $this->novaPoshtaService->getDeliveryCost($cityRecipientRef);
        return response()->json(['cost' => $cost]);
    }
}
