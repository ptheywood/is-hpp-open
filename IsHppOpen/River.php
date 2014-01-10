<?php
/**
 * Class to model river data returned from rainchasers.
 * @author Peter Heywood
 * @version 0.1.0
 */
namespace IsHppOpen;

class River {
    private $uuid, $url, $river, $state;
    private $eaLevel;

    /**
     * Constructor allowing simple loading from a json string 
     * @param string $json
     * @author Peter Heywood <peethwd@gmail.com>
     */
    function __construct($json = null){
        $this->loadFromJson($json);
    }

    /**
     * Populate instance variables based on json object from api.
     * @param  string $json
     * @author Peter Heywood <peethwd@gmail.com>
     */
    private function loadFromJson($json){
        if(isset($json["uuid"])){
            $this->uuid = $json["uuid"];
        }
        if(isset($json["url"])){
            $this->url = $json["url"];
        }
        if(isset($json["river"])){
            $this->river = $json["river"];
        }
        if(isset($json["state"])){
            $this->state = (object) $json["state"];
            if(isset($json["state"]["source"]["value"])){
                $this->eaLevel = $json["state"]["source"]["value"];
            }
        }

    }

    /**
     * Getter method for uuid class variable
     * @return string
     * @author Peter Heywood <peethwd@gmail.com>
     */
    public function getUuid(){
        return $this->uuid;
    }

    /**
     * Getter method for url class variable
     * @return string
     * @author Peter Heywood <peethwd@gmail.com>
     */
    public function getUrl(){
        return $this->url;
    }

    /**
     * Getter method for river class variable
     * @return string
     * @author Peter Heywood <peethwd@gmail.com>
     */
    public function getRiver(){
        return $this->river;
    }

    /**
     * Getter method for state class variable
     * @return string
     * @author Peter Heywood <peethwd@gmail.com>
     */
    public function getState(){
        return $this->state;
    }

    /**
     * Getter method for eaLevel class variable
     * @return string
     * @author Peter Heywood <peethwd@gmail.com>
     */
    public function getEaLevel(){
        return $this->eaLevel;
    }

    /**
     * Encodes the object into json format for storage.
     * @return string
     */
    public function encodeToJson(){
        return json_encode(get_object_vars($this));
    }

    /**
     * Decode json string into instance of this object.
     * @param  string $json
     * @return \IsHppOpen\River
     */
    public static function decodeFromJson($json){
        $decoded = json_decode($json);
        $obj = new River();

        $obj->uuid = (isset($decoded->uuid)) ? $decoded->uuid : null;
        $obj->url = (isset($decoded->url)) ? $decoded->url : null;
        $obj->river = (isset($decoded->river)) ? $decoded->river : null;
        $obj->state  = (isset($decoded->state)) ? $decoded->state : null;
        $obj->eaLevel = (isset($decoded->eaLevel)) ? $decoded->eaLevel : null;

        return $obj;
    }

}