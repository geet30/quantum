<?php

use Monolog\Logger;
use Jenssegers\Agent\Agent;
use Monolog\Handler\StreamHandler;
use Illuminate\Support\Facades\DB;


if (!function_exists('successResponse')) {

  function successResponse($msg, $code, $data = [])
  {
    return response()->json(['status' => true, 'code' => $code, 'message' => $msg, 'data' =>  $data], HTTP_STATUS_OK);
  }
}

if (!function_exists('errorResponse')) {

  function errorResponse($errors, $httpCode, $errorCode, $method = null)
  {
    $msg = $errors;
    if (is_array($errors) && count($errors)) {
      $msg = 'Please resolve all captured errors';
    }
    $httpCode = getHttpStatusCode($httpCode);
    
    // if ($method && config('env.EXCEPTION_ENABLED')) {
    //   dispatch(new \App\Jobs\SendExceptionMail($msg, $method));
    // }
    
    return response()->json(['status' => false, 'code' => $errorCode, 'message' => $msg, 'errors' => $errors], $httpCode);
  }
}

if (!function_exists('getHttpStatusCode')) {

  function getHttpStatusCode($code)
  {
    if ($code == 0 || is_string($code)) {
      return 400;
    }

    return $code;
  }
}




	
