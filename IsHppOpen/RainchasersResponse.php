<?php
/**
 * Class to handle repsonses from rainchasers api requests
 * @author Peter Heywood
 * @version 0.1.0
 */
namespace IsHppOpen;

class RainchasersResponse {

    private $status, $meta, $data, $river, $timeOfResponse;

    /**
     * Constructor that allows optional automatic processing of JSON
     * @param string $json string of json from rainchasers
     * @author  Peter Heywood <peethwd@gmail.com>
     */
    function __construct($json = null){
        if($json != null){
            $this->processRainchasersRequest($json);
        }
    }

    /**
     * Process the json string returned by the api, to create a fully populated instance of this class.
     * @param  string $json
     * @author  Peter Heywood <peethwd@gmail.com>
     */
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

    /**
     * Decide if the returned statis is good or not.
     * @return boolean
     * @author  Peter Heywood <peethwd@gmail.com>
     */
    public function goodStatus(){
        return $this->status == 200;
    }

    /**
     * Getter method for the data instance variable
     * @return StdObject
     * @author  Peter Heywood <peethwd@gmail.com>
     */
    public function getData(){
        return $this->data;
    }

    /**
     * Getter method for the river instance variable
     * @return StdObject
     * @author  Peter Heywood <peethwd@gmail.com>
     */
    public function getRiver(){
        return $this->river;
    }

    /**
     * Getter method for the timeOfResponse instance variable
     * @return timestamp
     * @author  Peter Heywood <peethwd@gmail.com>
     */
    public function getTimeOfResponse(){
        return $this->timeOfResponse;
    }

    /**
     * Encode the current instance as json for storage.
     * @return string
     * @author  Peter Heywood <peethwd@gmail.com>
     */
    public function encodeToJson(){
        $vars = get_object_vars($this);
        $vars["river"] = json_decode($this->river->encodeToJson());

        return json_encode($vars);
    }

    /**
     * Decode an instance from stored json. 
     * @param  string $encodedJson
     * @return \IsHppOpen\RainchasersResponse
     * @author  Peter Heywood <peethwd@gmail.com>
     */
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
