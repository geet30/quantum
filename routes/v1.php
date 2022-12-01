<?php


use App\Http\Controllers\V1\Vaults\VaultsController;


/*
|--------------------------------------------------------------------------
| Application Version One Routes
|--------------------------------------------------------------------------
|
| 
|
*/

/**  Write those API's here which need token authntications **/
$router->group(['middleware' => 'auth'], function () use ($router) {


});
$router->group(['middleware' => 'cors','prefix' => 'vaults'], function () use ($router) {
    $router->any('/', [VaultsController::class, 'getvaults']);
    $router->any('{id}/detail/graph', [VaultsController::class, 'getVaultGraph']);
    $router->any('{id}/detail/asset_info', [VaultsController::class, 'getVaultAssets']);
    $router->any('{id}/detail/transaction_detail', [VaultsController::class, 'getVaultTransaction']);
});