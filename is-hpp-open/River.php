<?php
/**
 * Class to model river data returned from rainchasers.
 * @author Peter Heywood
 * @version 0.1.0
 */

class River {
    private $uuid, $url, $river, $state;
    private $eaLevel;

    function __construct($json = null){
        $this->loadFromJson($json);
    }

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

    public function getUuid(){
        return $this->uuid;
    }

    public function getUrl(){
        return $this->url;
    }

    public function getRiver(){
        return $this->river;
    }

    public function getState(){
        return $this->state;
    }

    public function getEaLevel(){
        return $this->eaLevel;
    }

    public function encodeToJson(){
        return json_encode(get_object_vars($this));
    }
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