<?php

function getAuth($key = null)
{
    $ci = get_instance();
    $auth = $ci->session->userdata('session_meeting');
    if ($key == null) {
        return $auth;
    } else {
        $auth = (array) $auth;
        return isset($auth[$key]) ? $auth[$key] : null;
    }
}

/** 
 * Get header Authorization
 * */
function getHeader($key = 'Authorization')
{
    $http_key = 'HTTP_' . str_replace('-', '_', strtoupper($key));
    $headers = null;
    if (isset($_SERVER[$key])) {
        $headers = trim($_SERVER[$key]);
    } else if (isset($_SERVER[$http_key])) { //Nginx or fast CGI
        $headers = trim($_SERVER[$http_key]);
    } elseif (function_exists('apache_request_headers')) {
        $requestHeaders = apache_request_headers();
        // Server-side fix for bug in old Android versions (a nice side-effect of this fix means we don't care about capitalization for Authorization)
        $requestHeaders = array_combine(array_map('strtoupper', array_keys($requestHeaders)), array_values($requestHeaders));
        if (isset($requestHeaders[strtoupper($key)])) {
            $headers = trim($requestHeaders[strtoupper($key)]);
        }
    }
    return $headers;
}

/**
 * get access token from header
 * */
function getBearerToken()
{
    $headers = getHeader();
    if (!$headers) $headers = getHeader('X-authorization');
    // HEADER: Get the access token from the header
    if (!empty($headers)) {
        return trim(str_ireplace('Bearer', '', $headers));
    }
    return null;
}
