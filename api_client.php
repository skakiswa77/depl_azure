<?php

require_once 'config.php';

class ApiClient {
    private $baseUrl;
    
    public function __construct($baseUrl) {
        $this->baseUrl = $baseUrl;
    }
    
    public function get($endpoint, $id = null) {
        $url = $this->baseUrl . '/' . $endpoint;
        if ($id !== null) {
            $url .= '?id=' . $id;
        }
        
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        if ($httpCode >= 400) {
            throw new Exception("API error: HTTP code $httpCode");
        }
        
        return json_decode($response, true);
    }
    
    public function post($endpoint, $data) {
        $url = $this->baseUrl . '/' . $endpoint;
        
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        if ($httpCode >= 400) {
            throw new Exception("API error: HTTP code $httpCode");
        }
        
        return json_decode($response, true);
    }
    
    public function put($endpoint, $id, $data) {
        $url = $this->baseUrl . '/' . $endpoint . '?id=' . $id;
        
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        if ($httpCode >= 400) {
            throw new Exception("API error: HTTP code $httpCode");
        }
        
        return json_decode($response, true);
    }
    
    public function delete($endpoint, $id) {
        $url = $this->baseUrl . '/' . $endpoint . '?id=' . $id;
        
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        if ($httpCode >= 400) {
            throw new Exception("API error: HTTP code $httpCode");
        }
        
        return json_decode($response, true);
    }
}