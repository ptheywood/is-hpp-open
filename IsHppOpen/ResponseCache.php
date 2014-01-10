<?php
/**
 * Class to cache data from requests, to reduce api calls.
 * @author Peter Heywood
 * @version 0.1.0
 */
namespace IsHppOpen;

class ResponseCache {
    const CACHE_PATH = "/responseCache.json";

    /**
     * Get the response time from the cached response
     * @return mixed timestamp or false.
     * @author  Peter Heywood <peethwd@gmail.com>
     */
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

    /**
     * Get the RainchasersResponse from the cache file
     * @return mixed \IsHppOpen\RainchasersResponse or false
     * @author  Peter Heywood <peethwd@gmail.com>
     */
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

    /**
     * Store a Rainchasers Response into the cache file
     * @param  \IsHppOpen\RainchasersResponse $rainchasersResponse
     * @return boolean
     * @author  Peter Heywood <peethwd@gmail.com>
     */
    public static function cacheResponse($rainchasersResponse){
        // Encode the repsones
        $json = $rainchasersResponse->encodeToJson();
        // write to file
        $success = file_put_contents(dirname(__FILE__) . self::CACHE_PATH, $json);
        return $success;
    }

    /**
     * Check if the cache file exists
     * @return boolean
     * @author  Peter Heywood <peethwd@gmail.com>
     */
    public static function cacheExists(){
        return file_exists(dirname(__FILE__) . self::CACHE_PATH);
    }

    /**
     * Load the RainchasersResponse contained within the cache file
     * @return mixed \IsHppOpen\RainchasersResponse or false
     * @author  Peter Heywood <peethwd@gmail.com>
     */
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
