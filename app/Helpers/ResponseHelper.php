<?php
namespace App\Helpers;

class ResponseHelper
{
    public function successResponseData($message,$data) {
        return response()->json([
            'status' => 200,
            'message' => $message,
            'data' => $data
        ]);
    }

    public function successData($data) {
        return response()->json([
            'status' => 200,
            'data' => $data
        ]);
    }

    public function successResponse($message) {
        return response()->json([
            'status' => 200,
            'message' => $message
        ]);
    }

    public function errorResponse($message) {
        return response()->json([
            'status' => 500,
            'success' => false,
            'message' => $message
        ]); 
    }
    public function expiredResponse($message) {
        return response()->json([
            'status' => 500,
            'success' => false,
            'message' => $message
        ]); 
    }
}