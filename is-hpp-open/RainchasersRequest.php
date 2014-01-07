<?php
/**
 * Class to load data from the rainchasers API
 * @author Peter Heywood
 * @version 0.1.0
 */
require("RainchasersResponse.php");

class RainchasersRequest {

    private $endpoint, $userAgent;

    function __construct($endpoint, $userAgent){
        $this->endpoint = $endpoint;
        $this->userAgent = $userAgent;
    }

    public function requestRiver($uuid){
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
        
        return $response;
    }

}