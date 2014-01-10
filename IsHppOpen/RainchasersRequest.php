<?php
/**
 * Class to load data from the rainchasers API
 * @author Peter Heywood
 * @version 0.1.0
 */
namespace IsHppOpen;

class RainchasersRequest {

    private $endpoint, $userAgent, $waitTime;

    /**
     * Constructor for rainchasers requests with 3 paramaters
     * @param String $endpoint target end point for api request
     * @param String $userAgent user agent string to identify the application
     * @param int $waitTime time in seconds to wait between requests
     */
    function __construct($endpoint, $userAgent, $waitTime){
        $this->endpoint = $endpoint;
        $this->userAgent = $userAgent;
        $this->waitTime = $waitTime;
    }

    /**
     * Make a request about a river specified by it's uuid
     * @param  string $uuid
     * @return \IsHppOpen\RainchasersResponse
     */
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
                $cached = ResponseCache::cacheResponse($response);
                if($cached === false){
                    // @todo nicer error
                    var_dump("Caching error");
                }
            }

            return $response;
        } else {
            // @todo Error handling?
            $response = ResponseCache::getCachedRainchasersResponse();
            return $response;
        }

    }

    /**
     * Check if the last api request was long enough ago to make a new request
     * @return boolean
     */
    private function requestFrequencyOK(){
        $currentTime = time();
        $lastRequestTime = ResponseCache::getLastResponseTime();
        return ($lastRequestTime + $this->waitTime) < $currentTime ;
    }
}
