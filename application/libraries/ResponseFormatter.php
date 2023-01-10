<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ResponseFormatter
{
    /**
     * API Response
     *
     * @var array
     */
    protected static $response = [
        'meta' => [
            'code' => 200,
            'status' => 'success',
            'message' => null,
        ],
        'data' => null,
    ];

    /**
     * Give success response.
     */
    public static function success($data = null, $message = null)
    {
        self::$response['meta']['message'] = $message;
        self::$response['data'] = $data;

        self::response(self::$response, self::$response['meta']['code']);
    }

    /**
     * Give error response.
     */
    public static function error($data = null, $message = null, $code = 500)
    {
        self::$response['meta']['status'] = 'error';
        self::$response['meta']['code'] = $code;
        self::$response['meta']['message'] = $message;
        self::$response['data'] = $data;

        self::response(self::$response, self::$response['meta']['code']);
    }

    public static function response($data, $code)
    {
        echo json_encode($data);

        // For 4.3.0 <= PHP <= 5.4.0
        if (!function_exists('http_response_code')) {
            header('X-PHP-Response-Code: ' . $code, true, $code);
        } else {
            http_response_code($code);
        }
        die();
    }
}
