<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use function response;


class ApiController extends Controller
{

    const CODE_VALIDATION_ERROR = 422;
    const CODE_SUCCESS_UPDATED = 202;
    const CODE_SUCCESS = 200;
    const CODE_SUCCESS_CREATED = 201;
    const CODE_SUCCESS_DELETED = 202;
    const CODE_SUCCESS_FALSE = 555;
    const CODE_ACCESS_DENIED = 403;

//    /**
//     * @OA\Info(
//     *     version="1.0",
//     *     title="Agronews api"
//     *
//     * )
//     * @OA\Server(
//     *      url=L5_SWAGGER_CONST_HOST,
//     *      description="API Server O'Agronews"
//     * )
//     *
//     * @OA\SecurityScheme(
//     *      securityScheme="bearer_token",
//     *      type="http",
//     *      scheme="bearer"
//     * )
//     * @OA\PathItem(path="/v1/")
//     */

    public function __construct()
    {
        $this->headers = ['Access-Control-Allow-Origin' => '*', 'Access-Control-Allow-Headers' => 'Content-Type, X-Auth-Token, Origin'];
    }

    public function responseSuccess($response): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => $response
        ], self::CODE_SUCCESS)->withHeaders($this->headers);
    }

    public function responseMessage($response, $code = self::CODE_SUCCESS): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'success' => ($code == self::CODE_SUCCESS),
            'message' => $response
        ], $code)->withHeaders($this->headers);
    }

//    public function responseValidation($response)
//    {
//        $errors = [];
//        foreach ($response as $field => $message) {
//            $messageStandard = [];
//            foreach ($message as $key => $translate) {
//                $messageStandard[] = [
//                    'key' => $key,
//                    'text' => $translate
//                ];
//            }
//            $errors[] = [
//                'field' => $field,
//                'message' => $messageStandard
//            ];
//        }
//        return response()->json([
//            'success' => false,
//            'errors' => $errors
//        ], self::CODE_VALIDATION_ERROR)->withHeaders($this->headers);
//    }

    public function responseSave($response, $errorData = [])
    {
        if ($response || is_null($response))
            return response()->json(['success' => true, 'data' => $response], self::CODE_SUCCESS_CREATED)->withHeaders($this->headers);
        return response()->json(['success' => false, 'data' => $errorData], self::CODE_SUCCESS_FALSE)->withHeaders($this->headers);
    }

    public function responseUpdate($response)
    {
        if ($response || is_null($response))
            return response()->json([
                'success' => true,
                'data' => "data changed successfully"
            ], self::CODE_SUCCESS_UPDATED)->withHeaders($this->headers);
        return response()->json(['success' => false], self::CODE_SUCCESS_FALSE)->withHeaders($this->headers);
    }

    public function responseDelete($response)
    {
        if ($response)
            return response()->json(['success' => true], self::CODE_SUCCESS_DELETED)->withHeaders($this->headers);
        return response()->json(['success' => false], self::CODE_SUCCESS_FALSE)->withHeaders($this->headers);
    }

}
