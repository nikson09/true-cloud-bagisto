<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\NovaPoshtaService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class NovaPoshtaController extends Controller
{
    private NovaPoshtaService $novaPoshtaService;

    public function __construct(NovaPoshtaService $novaPoshtaService)
    {
        $this->novaPoshtaService = $novaPoshtaService;
    }

    /**
     * Get all areas (regions) of Ukraine
     *
     * @return JsonResponse
     */
    public function getAreas(): JsonResponse
    {
        try {
            $areas = $this->novaPoshtaService->getAreas();
            
            return response()->json([
                'success' => true,
                'data' => $areas
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch areas',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get cities by area reference
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getCities(Request $request): JsonResponse
    {
        $request->validate([
            'area_ref' => 'required|string'
        ]);

        try {
            $cities = $this->novaPoshtaService->getCities($request->area_ref);
            
            return response()->json([
                'success' => true,
                'data' => $cities
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch cities',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get warehouses by city reference
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getWarehouses(Request $request): JsonResponse
    {
        $request->validate([
            'city_ref' => 'required|string'
        ]);

        try {
            $warehouses = $this->novaPoshtaService->getWarehouses($request->city_ref);
            
            return response()->json([
                'success' => true,
                'data' => $warehouses
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch warehouses',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Search cities
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function searchCities(Request $request): JsonResponse
    {
        $request->validate([
            'search' => 'nullable|string|max:255'
        ]);

        try {
            $cities = $this->novaPoshtaService->getAllCities($request->search);
            
            return response()->json([
                'success' => true,
                'data' => $cities
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to search cities',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
