<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class NovaPoshtaService
{
    private string $apiKey;
    private string $baseUrl = 'https://api.novaposhta.ua/v2.0/json/';

    public function __construct()
    {
        $this->apiKey = config('services.nova_poshta.api_key', '');
    }

    /**
     * Get all regions (areas) of Ukraine
     *
     * @return array
     */
    public function getAreas(): array
    {
        return Cache::remember('nova_poshta_areas', 3600, function () {
            try {
                $response = Http::timeout(10)->withHeaders([
                    'Content-Type' => 'application/json',
                ])->post($this->baseUrl, [
                    'apiKey' => $this->apiKey,
                    'modelName' => 'Address',
                    'calledMethod' => 'getAreas',
                    'methodProperties' => new \stdClass()
                ]);
                if ($response->successful()) {
                    $data = $response->json();
                    Log::info('Nova Poshta Areas API response:', $data);
                    
                    if (isset($data['data']) && is_array($data['data'])) {
                        return collect($data['data'])->map(function ($area) {
                            return [
                                'ref' => $area['Ref'],
                                'description' => $area['Description'],
                                'description_ru' => $area['DescriptionRu'] ?? $area['Description'],
                            ];
                        })->toArray();
                    }
                }

                Log::error('Nova Poshta API error: ' . $response->body());
                Log::error('Nova Poshta API status: ' . $response->status());
                return [];
            } catch (\Exception $e) {
                Log::error('Nova Poshta API exception: ' . $e->getMessage());
                return [];
            }
        });
    }

    /**
     * Get cities by area reference
     *
     * @param string $areaRef
     * @return array
     */
    public function getCities(string $areaRef): array
    {
        $cacheKey = "nova_poshta_cities_{$areaRef}";
        
        return Cache::remember($cacheKey, 3600, function () use ($areaRef) {
            try {
                $response = Http::timeout(10)->withHeaders([
                    'Content-Type' => 'application/json',
                ])->post($this->baseUrl, [
                    'apiKey' => $this->apiKey,
                    'modelName' => 'Address',
                    'calledMethod' => 'getCities',
                    'methodProperties' => [
                        'AreaRef' => $areaRef
                    ]
                ]);

                if ($response->successful()) {
                    $data = $response->json();
                    if (isset($data['data']) && is_array($data['data'])) {
                        return collect($data['data'])->map(function ($city) {
                            return [
                                'ref' => $city['Ref'],
                                'description' => $city['Description'],
                                'description_ru' => $city['DescriptionRu'] ?? $city['Description'],
                                'area_ref' => $city['Area'],
                            ];
                        })->toArray();
                    }
                }

                Log::error('Nova Poshta API error: ' . $response->body());
                return [];
            } catch (\Exception $e) {
                Log::error('Nova Poshta API exception: ' . $e->getMessage());
                return [];
            }
        });
    }

    /**
     * Get warehouses (departments) by city reference
     *
     * @param string $cityRef
     * @return array
     */
    public function getWarehouses(string $cityRef): array
    {
        $cacheKey = "nova_poshta_warehouses_{$cityRef}";
        
        return Cache::remember($cacheKey, 3600, function () use ($cityRef) {
            try {
                $response = Http::timeout(10)->withHeaders([
                    'Content-Type' => 'application/json',
                ])->post($this->baseUrl, [
                    'apiKey' => $this->apiKey,
                    'modelName' => 'AddressGeneral',
                    'calledMethod' => 'getWarehouses',
                    'methodProperties' => [
                        'CityRef' => $cityRef
                    ]
                ]);

                if ($response->successful()) {
                    $data = $response->json();
                    if (isset($data['data']) && is_array($data['data'])) {
                        return collect($data['data'])->map(function ($warehouse) {
                            return [
                                'ref' => $warehouse['Ref'],
                                'description' => $warehouse['Description'],
                                'description_ru' => $warehouse['DescriptionRu'] ?? $warehouse['Description'],
                                'city_ref' => $warehouse['CityRef'],
                                'number' => $warehouse['Number'] ?? '',
                            ];
                        })->toArray();
                    }
                }

                Log::error('Nova Poshta API error: ' . $response->body());
                return [];
            } catch (\Exception $e) {
                Log::error('Nova Poshta API exception: ' . $e->getMessage());
                return [];
            }
        });
    }

    /**
     * Get all cities (for search functionality)
     *
     * @param string|null $search
     * @return array
     */
    public function getAllCities(?string $search = null): array
    {
        $cacheKey = 'nova_poshta_all_cities';
        
        $cities = Cache::remember($cacheKey, 3600, function () {
            try {
                $response = Http::timeout(30)->withHeaders([
                    'Content-Type' => 'application/json',
                ])->post($this->baseUrl, [
                    'apiKey' => $this->apiKey,
                    'modelName' => 'Address',
                    'calledMethod' => 'getCities',
                    'methodProperties' => new \stdClass()
                ]);

                if ($response->successful()) {
                    $data = $response->json();
                    if (isset($data['data']) && is_array($data['data'])) {
                        return collect($data['data'])->map(function ($city) {
                            return [
                                'ref' => $city['Ref'],
                                'description' => $city['Description'],
                                'description_ru' => $city['DescriptionRu'] ?? $city['Description'],
                                'area_ref' => $city['Area'],
                            ];
                        })->toArray();
                    }
                }

                Log::error('Nova Poshta API error: ' . $response->body());
                return [];
            } catch (\Exception $e) {
                Log::error('Nova Poshta API exception: ' . $e->getMessage());
                return [];
            }
        });

        if ($search) {
            $search = mb_strtolower($search);
            $cities = array_filter($cities, function ($city) use ($search) {
                return strpos(mb_strtolower($city['description']), $search) !== false ||
                       strpos(mb_strtolower($city['description_ru']), $search) !== false;
            });
        }

        return array_values($cities);
    }
}
