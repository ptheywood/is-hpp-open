<?php
/**
 * Class to be invoked to find out if HPP is open or not
 * @author Peter Heywood
 * @version 0.1.0
 */

class IsHppOpen {

    const VAGUE_TRUE_RESPONSE = "Probably";
    const VAGUE_FALSE_RESPONSE = "Probably not";

    function __construct__(){

    }

    public function check($vagueResponses = false){

        $isOpen = true; // Bool, temp true until full implementation
        
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
    }
}