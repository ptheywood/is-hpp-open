<?php
/**
 * Class to be invoked to find out if HPP is open or not
 * @author Peter Heywood
 * @version 0.1.0
 */
require("RainchasersRequest.php");

class IsHppOpen {

    const VAGUE_TRUE_RESPONSE = "Probably";
    const VAGUE_FALSE_RESPONSE = "Probably not";
    const CONFIG_FILE = "config.ini";

    private $config = array();
    private $validConfig = false;

    function __construct(){
        // Load configuration
        $this->loadConfig();
        // Validate config
        $this->validConfig = $this->validateConfig();

    }

    private function loadConfig(){
        $this->config = parse_ini_file(self::CONFIG_FILE);
    }

    private function validateConfig(){
        // Check config fields are all valid.
        $errors = array();

        if(!isset($this->config["user-agent"]) || strlen($this->config["user-agent"]) == 0){
            $errors["user-agent"] = "'user-agent' must be set";
        }
        if(!isset($this->config["endpoint"]) || strlen($this->config["endpoint"]) == 0){
            $errors["endpoint"] = "'endpoint' must be set";
        }
        if(!isset($this->config["trent-uuid"]) || strlen($this->config["trent-uuid"]) == 0){
            $errors["trent-uuid"] = "'trent-uuid' must be set";
        }
        if(!isset($this->config["cut-off-height"]) || strlen($this->config["cut-off-height"]) == 0){
            $errors["cut-off-height"] = "'cut-off-height' must be set";
        }

        if(count($errors) == 0){
            return true;
        } else {
            // @todo - Improve ivalid config output
            echo "INVALID CONFIG\\==============\\";
            var_dump($errors);
            return false;
        }

    }

    public function check($vagueResponses = false){
        // If the configuration is valid, check the level.
        if($this->validConfig){
            // Make request to rainchasers
            $request = new RainchasersRequest($this->config['endpoint'], $this->config['user-agent']);
            $response = $request->requestRiver($this->config['trent-uuid']);
            // Use the repsonse and config to decide if level is ok.

            $isOpen = $this->isLevelTooHigh($response);
            // Return boolean value if method parameter is false.
            if(!$vagueResponses){
                return $isOpen;
            } else {
                // Return appropriate vague response
                if($isOpen){
                    return self::VAGUE_TRUE_RESPONSE;
                } else {
                    return self::VAGUE_FALSE_RESPONSE;
                }
            }
        } else {
            // @todo - Correctly handle bad config with exception
            var_dump("CONFIG_BAD");
        }
    }

    private function isLevelTooHigh($rainchasersResponse){
        // If the response is good.
        if($rainchasersResponse->goodStatus()){
            // Grab the river level.
            $guageLevel = $rainchasersResponse->getRiver()->getEaLevel();
            return ($guageLevel > $this->config["cut-off-height"]);

        } else {
            // @todo - propper error handling
            var_dump("BAD RESPONSE");
            return NULL;
        }
    }
}