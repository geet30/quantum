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
    $router->get('{id}/detail/graph', [VaultsController::class, 'getVaultGraph']);
    $router->get('{id}/detail/asset_info', [VaultsController::class, 'getVaultAssets']);
    $router->get('{id}/detail/transaction_detail', [VaultsController::class, 'getVaultTransaction']);
});