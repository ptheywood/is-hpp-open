<?php
/**
 * Class to load data from the rainchasers API
 * @author Peter Heywood
 * @version 0.1.0
 */
require_once("RainchasersResponse.php");
require_once("ResponseCache.php");

class RainchasersRequest {

    private $endpoint, $userAgent, $waitTime;

    function __construct($endpoint, $userAgent, $waitTime){
        $this->endpoint = $endpoint;
        $this->userAgent = $userAgent;
        $this->waitTime = $waitTime;
    }

    public function requestRiver($uuid){
        if($this->requestFrequencyOK()){
            $url = $this->endpoint . $uuid;
            // Create context for file request.
            $options = array(
                "http" => array(
                    "method" => "GET",
                    "user_agent" => $this->userAgent
                )
            );
            $context = stream_context_create($options);
            $json = json_decode(file_get_contents($url, false, $context), true);
            
            $response = new RainchasersResponse($json);

            if($response->goodStatus()){
                ResponseCache::cacheResponse($response);
            }

            return $response;
        } else {
            // @todo Error handling?
            $response = ResponseCache::getCachedRainchasersResponse();
            return $response;
        }

    }

    private function requestFrequencyOK(){
        $currentTime = time();
        $lastRequestTime = ResponseCache::getLastResponseTime();
        return ($lastRequestTime + $this->waitTime) < $currentTime ;
    }
}