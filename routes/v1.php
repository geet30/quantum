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

$router->get('vaults', [VaultsController::class, 'getvaults']);
