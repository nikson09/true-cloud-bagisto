<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\NovaPoshtaController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Nova Poshta API routes
Route::prefix('api/nova-poshta')->group(function () {
    Route::get('areas', [NovaPoshtaController::class, 'getAreas'])->name('api.nova-poshta.areas');
    Route::get('cities', [NovaPoshtaController::class, 'getCities'])->name('api.nova-poshta.cities');
    Route::get('warehouses', [NovaPoshtaController::class, 'getWarehouses'])->name('api.nova-poshta.warehouses');
    Route::get('cities/search', [NovaPoshtaController::class, 'searchCities'])->name('api.nova-poshta.cities.search');
});
