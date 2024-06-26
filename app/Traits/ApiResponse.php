<?php

namespace App\Traits;


use App\Models\Product;
use Illuminate\Http\Response;
// use Maansu\Hashing\Hashing;


trait ApiResponse
{
    /**
     * Build success response
     * @param  string|array $data
     * @param  string $message
     * @param  int $code
     * @return Illuminate\Http\JsonResponse
     */



    public function successResponseIndex($data=[], $message = '',$count='',$user='', $code = Response::HTTP_OK)
    {
        return response()->json(['success'=>true, 'message'=>$message, 'data' => $data,'count'=>$count], $code);
    }

    public function successResponse($data=[], $message = '', $code = Response::HTTP_OK)
    {
        return response()->json(['success'=>true, 'message'=>$message, 'data' => $data], $code);
    }

    /**
     * Build error response
     * @param  string|array $data
     * @param  string $message
     * @param  int $error_code
     * @param  array $errors
     * @param  int $code
     * @return Illuminate\Http\JsonResponse
     */
    public static function errorResponse($message = '')
    {
        return response()->json(['success' => false, 'message' => $message], $code= Response::HTTP_OK);
    }
}
