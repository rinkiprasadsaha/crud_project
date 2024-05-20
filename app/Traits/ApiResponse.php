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

    // public static function successResponse($id)
    // {
    //     $product= Product::find($id);
    //     return response()->json(['success' => true, 'message' => 'Restore successfully', 'data' => $product], $code= Response::HTTP_OK);
    // }

    public function successResponseIndex($data=[], $message = '',$count='', $code = Response::HTTP_OK)
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
    public static function errorResponse()
    {
        return response()->json(['success' => false, 'message' => "No item found"], $code= Response::HTTP_OK);
    }
}
