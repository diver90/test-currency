<?php

namespace App\Http\Controllers;

use App\Models\Rate;
use App\Services\RateService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class ApiController extends Controller
{
    /**
     * success response method.
     *
     * @return JsonResponse
     */
    public function sendResponse($result, $timestamp): JsonResponse
    {
        $response = [
            'success' => true,
            'data'    => $result,
            'timestamp' => $timestamp,
        ];


        return response()->json($response, 200);
    }

    /**
     * return error response.
     *
     * @return JsonResponse
     */
    public function sendError($error, $errorMessages = [], $code = 404): JsonResponse
    {
        $response = [
            'success' => false,
            'message' => $error,
        ];


        if(!empty($errorMessages)){
            $response['data'] = $errorMessages;
        }


        return response()->json($response, $code);
    }


    public function convert(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'sum'   => 'required',
            'base'  => 'required|exists:currencies,symbol',
            'quote' => 'required|exists:currencies,symbol',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $sum = $data['sum'];

        [$result, $timestamp] = RateService::calcAmount($sum, $data['base'],$data['quote']);


        return $this->sendResponse($result, $timestamp);
    }
}
