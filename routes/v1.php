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
$router->group(['prefix' => 'vaults'], function () use ($router) {
    $router->get('/', [VaultsController::class, 'getvaults']);
    $router->get('detail/graph/{id}', [VaultsController::class, 'getVaultGraph']);
    $router->get('detail/asset_info/{id}', [VaultsController::class, 'getVaultAssets']);
});
