<?php

namespace App\Http\Controllers\V1\Vaults;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\Vaults;
class VaultsController extends Controller{

    public function getvaults(Request $request)
    {
        
        
        try {
            $data = Vaults::getVaultData($request);
            if (!$data) {
                return errorResponse('Data Not Found', HTTP_STATUS_NOT_FOUND, HTTP_ERROR_CODE);
            } else {
                return successResponse('Data Found Successfully', HTTP_STATUS_OK, $data);
            }
        } catch (\Exception $e) {
            return errorResponse($e->getMessage(), HTTP_STATUS_SERVER_ERROR, HTTP_ERROR_CODE, __FUNCTION__);
        }
    }

   
    
    
   

}