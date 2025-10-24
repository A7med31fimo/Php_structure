<?php

namespace App\Helpers;

class Helper
{


    public function __construct() {}



    /**
     * Solve the dot reference like database.host
     * @param string $key
     * @return mixed
     */
    public static function getBYDot(string $key)
    {
        $config = explode(".", $key);
        if (count($config) > 0) {
            $result = include __DIR__ . "/../" . $config[0] . ".php";
            return $result[$config[1]] ?? null;
        }
    }


    public static function jsonResponse($data, $status = 200)
    {
        header('Content-Type: application/json; charset=UTF-8');
        http_response_code($status);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        exit;
    }


    public static function getInput()
    {
        return json_decode(file_get_contents('php://input'), true);
    }

    public static function noCacheHeaders()
    {
        header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
    }
    
}
//                     case 100: = 'Continue'
//                     case 101: = 'Switching Protocols'
//                     case 200: = 'OK'
//                     case 201: = 'Created'
//                     case 202: = 'Accepted'
//                     case 203: = 'Non-Authoritative Information'
//                     case 204: = 'No Content'
//                     case 205: = 'Reset Content'
//                     case 206: = 'Partial Content'
//                     case 300: = 'Multiple Choices'
//                     case 301: = 'Moved Permanently'
//                     case 302: = 'Moved Temporarily'
//                     case 303: = 'See Other'
//                     case 304: = 'Not Modified'
//                     case 305: = 'Use Proxy'
//                     case 400: = 'Bad Request'
//                     case 401: = 'Unauthorized'
//                     case 402: = 'Payment Required'
//                     case 403: = 'Forbidden'
//                     case 404: = 'Not Found'
//                     case 405: = 'Method Not Allowed'
//                     case 406: = 'Not Acceptable'
//                     case 407: = 'Proxy Authentication Required'
//                     case 408: = 'Request Time-out'
//                     case 409: = 'Conflict'
//                     case 410: = 'Gone'
//                     case 411: = 'Length Required'
//                     case 412: = 'Precondition Failed'x
//                     case 413: = 'Request Entity Too Large'
//                     case 414: = 'Request-URI Too Large'
//                     case 415: = 'Unsupported Media Type'
//                     case 500: = 'Internal Server Error'
//                     case 501: = 'Not Implemented'
//                     case 502: = 'Bad Gateway'
//                     case 503: = 'Service Unavailable'
//                     case 504: = 'Gateway Time-out'
//                     case 505: = 'HTTP Version not supported'
