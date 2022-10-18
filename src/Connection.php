<?php

namespace luanrodrigues\asaas\src;



use Asaas\Api\Exceptions\AccessTokenException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Support\Facades\Log;

class Connection {
    
    public $http;
    public $api_key;
    public $base_url;
    
    public function __construct($apiKey, $apiVersion = 'v3') {

        $this->api_key = $apiKey;

        if($apiVersion == 'v3'){
            $this->base_url = config('asaas.base_url');
        }

        if($apiVersion == 'v2'){
            $this->base_url = config('asaas.base_url_v2');
        }

        $this->http = new Client([
            'headers' => [
                'Content-Type' => 'application/json',
                'access_token' => $this->api_key
            ]
        ]);
        
        return $this->http;
    }
    
    public function get($url)
    {

        try{
            $response = $this->http->get($this->base_url . $url);

            return [
                'code'     => $response->getStatusCode(),
                'response' => json_decode($response->getBody()->getContents())
            ];
        }catch (\Exception $e){

            return [
                'code'     => $e->getCode(),
                'response' => $e->getMessage()
            ];
        }


        $response = $this->http->get($this->base_url . $url);
        //return json_decode($response->getBody()->getContents(), true);
    }
    
    public function post($url, $params)
    {
        //$response = $this->http->post($this->base_url . $url, $params);


        try{
            $response = $this->http->post($this->base_url . $url, $params);

            return [
                'code'     => $response->getStatusCode(),
                'response' => json_decode($response->getBody()->getContents())
            ];
        }catch (\Exception $e){

            return [
                'code'     => $e->getCode(),
                'response' => $e->getMessage()
            ];
        }
    }

    public function delete($url)
    {
        $response = $this->http->delete($this->base_url . $url);
        return json_decode($response->getBody()->getContents(), true);
    }
    
}