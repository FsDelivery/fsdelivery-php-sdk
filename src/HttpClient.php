<?php

namespace FsDeliverySdk;

class HttpClient
{
    /** @var string */
    private $url;
    /** @var int  */
    private $timeout = 60;
    public $headers = [];
    public $http_status_code = 0;

    public function __construct($url, $timeout = 60) {
        $this->url = $url;
        $this->timeout = $timeout;
    }

    public function get($method, $params = [], $headers = []) {
        return $this->request('GET', $method, $params, $headers);
    }

    public function post($method, $params = [], $headers = []) {
        return $this->request('POST', $method, $params, $headers);
    }

    private function request($method, $url, $params = [], $headers = []) {
        $curlHeaders = [];
        $this->http_status_code = 0;
        $this->headers = [];

        foreach ($headers as $header => $value) {
            $curlHeaders[] = $header.': '.$value;
        }

        if ($method == 'GET' && !empty($params))
            $url .= '?'.http_build_query($params);

        $curl = curl_init($this->url.$url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $curlHeaders);
        curl_setopt($curl, CURLOPT_TIMEOUT, $this->timeout);

        if ($method == 'POST') {
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($params));
        }

        $response = curl_exec($curl);
        $this->headers = curl_getinfo($curl);
        $this->http_status_code = !empty($this->headers['http_code']) ? $this->headers['http_code'] : 0;
        curl_close($curl);

        return $response;
    }
}