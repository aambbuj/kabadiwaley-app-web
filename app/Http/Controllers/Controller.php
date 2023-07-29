<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function sendResponse($result, $message)
    {
    	$response = [
            'success' => true,
            'status' => 200,
            'message' => $message,
            'data'    => $result,
        ];
        return response()->json($response, 200);
    }


    public function sendError($errorMessages)
    {
    	$response = [
            'success' => false,
            'status' => 400,
            'error' => $errorMessages,
        ];
        
        return response()->json($response);
    }
}
