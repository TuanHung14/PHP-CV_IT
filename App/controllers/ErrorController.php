<?php

namespace App\Controllers;

class ErrorController
{
    public static function notFound($message = "Not found")
    {
        http_response_code(404);
        loadViewError('error', [
            'status' => 404,
            'message' => $message
        ]);
    }

    public static function unauthorized($message = "Bạn không có quyền truy cập vào trang này")
    {
        http_response_code(401);
        loadViewError('error', [
            'status' => 401,
            'message' => $message
        ]);
    }
}

