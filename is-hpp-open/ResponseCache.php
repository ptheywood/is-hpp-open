<?php
/**
 * Class to cache data from requests, to reduce api calls.
 * @author Peter Heywood
 * @version 0.1.0
 */
require_once("RainchasersResponse.php");

class ResponseCache {
    const CACHE_PATH = "./responseCache.json";


    public static function getLastResponseTime(){
        if(self::cacheExists()){
            $response = self::loadCache();
            if($response){
                return $response->getTimeOfResponse();
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public static function getCachedRainchasersResponse(){
        if(self::cacheExists()){
            $response = self::loadCache();
            if($response){
                return $response;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public static function cacheResponse($rainchasersResponse){
        // Encode the repsones
        $json = $rainchasersResponse->encodeToJson();
        // write to file
        file_put_contents(dirname(__FILE__) . self::CACHE_PATH, $json);
    }

    public static function cacheExists(){
        return file_exists(dirname(__FILE__) . self::CACHE_PATH);
    }

    private static function loadCache(){
        // Load from file
        $json = file_get_contents(dirname(__FILE__) . self::CACHE_PATH);
        // Decode into object
        if($json !== false){
            $response = RainchasersResponse::decodeFromJson($json);
            
            return $response;
        } else {
            return false;
        }
    }

}