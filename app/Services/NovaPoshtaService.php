<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class NovaPoshtaService
{
    protected $apiKey;
    protected $citySenderRef = 'db5c88ac-391c-11dd-90d9-001a92567626';  // Ref Хмельницького
    protected $warehouseSenderRef = 'd16c3e37-04ab-11e8-add7-005056886752';  // Ref відділення №22

    public function __construct()
    {
        $this->apiKey = config('novaposhta.api_key');
    }

    public function getCities()
    {
        $response = Http::post('https://api.novaposhta.ua/v2.0/json/', [
            'apiKey' => $this->apiKey,
            'modelName' => 'Address',
            'calledMethod' => 'getCities'
        ]);
        return $response->json()['data'];
    }

    public function getWarehouses($cityRef)
    {
        $response = Http::post('https://api.novaposhta.ua/v2.0/json/', [
            'apiKey' => $this->apiKey,
            'modelName' => 'Address',
            'calledMethod' => 'getWarehouses',
            'methodProperties' => [
                'CityRef' => $cityRef
            ]
        ]);

        return $response->json()['data'];
    }

    public function getDeliveryCost($cityRecipientRef, $weight = 1, $serviceType = 'WarehouseWarehouse')
    {
        $response = Http::post('https://api.novaposhta.ua/v2.0/json/', [
            'apiKey' => $this->apiKey,
            'modelName' => 'InternetDocument',
            'calledMethod' => 'getDocumentPrice',
            'methodProperties' => [
                'CitySender' => $this->citySenderRef,
                'CityRecipient' => $cityRecipientRef,
                'Weight' => $weight,
                'ServiceType' => $serviceType,
                'WarehouseSender' => $this->warehouseSenderRef,
            ]
        ]);

        return $response->json()['data'][0]['Cost'];
    }
}
