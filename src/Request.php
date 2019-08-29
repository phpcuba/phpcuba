<?php

namespace PHPCuba;

class Request
{

    /** @var array Request headers */
    public static $requestHeaders;

    /**
     * GET
     *
     * @param $url
     *
     * @return bool|mixed
     */
    public static function remoteGET($url, $headers = [])
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_URL, $url);

        $data = curl_exec($ch);

        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if ($httpCode === 404) {
            $data = false;
        }
        curl_close($ch);

        return $data;
    }

    /**
     * POST
     *
     * @param      $url
     * @param null $postData
     *
     * @return bool|mixed
     */
    public static function remotePOST($url, $postData = null, $headers = [])
    {
        $data_string = json_encode($postData);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HEADER, false);

        $headers[] = 'Content-Type: application/json';
        $headers[] = ' Content-Length: '.strlen($data_string);

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);

        $data = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if ($httpCode == 404) {
            $data = false;
        }

        curl_close($ch);

        return $data;
    }

    /**
     * Get and decode
     *
     * @param       $url
     *
     * @param array $headers
     *
     * @return mixed
     */
    public static function remoteGetJSON($url, $headers = [])
    {
        $data = self::remoteGET($url, $headers);

        return json_decode($data);
    }

    /**
     * Post and decode
     *
     * @param       $url
     * @param null  $postData
     *
     * @param array $headers
     *
     * @return mixed
     */
    public static function remotePostJSON($url, $postData = null, $headers = [])
    {
        $data = self::remotePOST($url, $postData, $headers);

        return json_decode($data);
    }

    /**
     * Get raw JSON from POST
     *
     * @return false|mixed|string
     */
    public static function getJSONPost()
    {
        $data = file_get_contents('php://input');
        $data = json_decode($data);

        return $data;
    }

    /**
     * Get POST value
     *
     * @param      $var
     * @param null $default
     *
     * @return mixed
     */
    public static function post($var, $default = null)
    {
        return Arrays::get($_POST, $var, $default);
    }

    /**
     * Get GET value
     *
     * @param      $var
     * @param null $default
     *
     * @return mixed
     */
    public static function get($var, $default = null)
    {
        return Arrays::get($_GET, $var, $default);
    }


    /**
     * Get all HTTP header key/values as an associative
     * array for the current request.
     *
     * @return array The HTTP header key/value pairs.
     */
    public static function getRequestHeaders(): array
    {
        if (self::$requestHeaders === null) {
            self::$requestHeaders = [];

            $copy_server = [
                'CONTENT_TYPE'   => 'Content-Type',
                'CONTENT_LENGTH' => 'Content-Length',
                'CONTENT_MD5'    => 'Content-Md5',
            ];

            foreach ($_SERVER as $key => $value) {
                if (strpos($key, 'HTTP_') === 0) {
                    $key = substr($key, 5);
                    if (!isset($copy_server[$key]) || !isset($_SERVER[$key])) {
                        $key = str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', $key))));
                        self::$requestHeaders[$key] = $value;
                    }
                } elseif (isset($copy_server[$key])) {
                    self::$requestHeaders[$copy_server[$key]] = $value;
                }
            }

            if (!isset(self::$requestHeaders['Authorization'])) {
                if (isset($_SERVER['REDIRECT_HTTP_AUTHORIZATION'])) {
                    self::$requestHeaders['Authorization'] = $_SERVER['REDIRECT_HTTP_AUTHORIZATION'];
                } elseif (isset($_SERVER['PHP_AUTH_USER'])) {
                    $basic_pass = $_SERVER['PHP_AUTH_PW'] ?? '';
                    self::$requestHeaders['Authorization'] = 'Basic '.base64_encode($_SERVER['PHP_AUTH_USER'].':'.$basic_pass);
                } elseif (isset($_SERVER['PHP_AUTH_DIGEST'])) {
                    self::$requestHeaders['Authorization'] = $_SERVER['PHP_AUTH_DIGEST'];
                }
            }

            if (function_exists('getallheaders')) {
                self::$requestHeaders = array_merge(self::$requestHeaders, getallheaders());
            }
        }

        return self::$requestHeaders;
    }

    /**
     * Return request header value
     *
     * @param      $header
     * @param null $default
     *
     * @return null
     */
    public static function getRequestHeader($header, $default = null)
    {
        return Arrays::get(self::getRequestHeaders(), $header, $default);
    }
}
