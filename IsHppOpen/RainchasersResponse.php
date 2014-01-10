<?php
/**
 * Class to handle repsonses from rainchasers api requests
 * @author Peter Heywood
 * @version 0.1.0
 */
namespace IsHppOpen;

class RainchasersResponse {

    private $status, $meta, $data, $river, $timeOfResponse;

    function __construct($json = null){
        if($json != null){
            $this->processRainchasersRequest($json);
        }
    }

    private function processRainchasersRequest($json){
        if(isset($json["status"])){
            $this->status = $json["status"];
        }
        if(isset($json["meta"])){
            $this->meta = $json["meta"];
        }
        if(isset($json["data"])){
            $this->data = $json["data"];
            $this->river = new River($json["data"]);
        }
        $this->timeOfResponse = time();

    }

    public function goodStatus(){
        return $this->status == 200;
    }

    public function getData(){
        return $this->data;
    }

    public function getRiver(){
        return $this->river;
    }

    public function getTimeOfResponse(){
        return $this->timeOfResponse;
    }

    public function encodeToJson(){
        $vars = get_object_vars($this);
        $vars["river"] = json_decode($this->river->encodeToJson());

        return json_encode($vars);
    }

    public static function decodeFromJson($encodedJson){
        $decoded = json_decode($encodedJson);

        $obj = new RainchasersResponse();

        $obj->status = (isset($decoded->status)) ? $decoded->status : null;
        $obj->meta = (isset($decoded->meta)) ? $decoded->meta : null;
        $obj->data = (isset($decoded->data)) ? $decoded->data : null;
        $obj->river = (isset($decoded->river)) ? River::decodeFromJson(json_encode($decoded->river)) : null;
        $obj->timeOfResponse = (isset($decoded->timeOfResponse)) ? $decoded->timeOfResponse : null;
        return $obj;
    }
}