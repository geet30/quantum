<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\V1\Vaults\VaultsController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

$router->group(['middleware' => 'cors','prefix' => 'vaults'], function () use ($router) {
    $router->get('/', [VaultsController::class, 'getvaults']);
    $router->get('detail/graph/{id}', [VaultsController::class, 'getVaultGraph']);
    $router->get('detail/asset_info/{id}', [VaultsController::class, 'getVaultAssets']);
    $router->get('detail/transaction_detail/{id}', [VaultsController::class, 'getVaultTransaction']);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
