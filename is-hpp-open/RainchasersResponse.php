<?php
/**
 * Class to handle repsonses from rainchasers api requests
 * @author Peter Heywood
 * @version 0.1.0
 */
require("River.php");

class RainchasersResponse {

    private $status, $meta, $data;
    private $river;

    function __construct($json){
        $this->processJson($json);
    }

    private function processJson($json){
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
}