<?php
/**
 * Class to be invoked to find out if HPP is open or not
 * @author Peter Heywood
 * @version 0.1.0
 */
namespace IsHppOpen;

class IsHppOpen {

    const VAGUE_TRUE_RESPONSE = "Probably";
    const VAGUE_FALSE_RESPONSE = "Probably not";
    const CONFIG_FILE = "config.ini";

    private $config = array();
    private $validConfig = false;
    private $riverData = null;

    /**
     * Simple constructor which loads and validates the configuration file.
     * @author  Peter Heywood <peethwd@gmail.com>
     */
    function __construct(){
        // Load configuration
        $this->loadConfig();
        // Validate config
        $this->validConfig = $this->validateConfig();

    }

    /**
     * Make private river data accessible from the main class, so the leve is accessible publically for output.
     * @return \IsHppOpen\River RiverData
     */
    public function getRiverData(){
        return $this->riverData;
    }

    /**
     * Parse config.ini to load the configuration array
     * @author Peter Heywood <peethwd@gmail.com>
     */
    private function loadConfig(){
        $this->config = parse_ini_file(self::CONFIG_FILE);
    }

    /**
     * Validate a loaded configuration to allow other functions to be used.
     * @return boolean indicating success
     * @author Peter Heywood <peethwd@gmail.com>
     */
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
        if(!isset($this->config["request-time-wait"]) || strlen($this->config["request-time-wait"]) == 0){
            $errors["request-time-wait"] = "'request-time-wait' must be set";
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

    /**
     * Check to see if HPP should be open or not based on rainchasers data and the config file.
     * @param  boolean $vagueResponses if true function will return vague string based responses rather than boolean
     * @return mixed boolean or string, indicating if the course should be open or not.
     * @author Peter Heywood <peethwd@gmail.com>
     */
    public function check($vagueResponses = false){
        // If the configuration is valid, check the level.
        if($this->validConfig){
            // Make request to rainchasers
            $request = new RainchasersRequest($this->config['endpoint'], $this->config['user-agent'], $this->config['request-time-wait']);
            $response = $request->requestRiver($this->config['trent-uuid']);
            $this->riverData = $response->getRiver();
            // Use the repsonse and config to decide if level is ok.

            $isOpen = !$this->isLevelTooHigh($response);
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

    /**
     * Compare the river level to the cut-off-height from the config to see if the level is too high for the course to be open or not.
     * @param  \IsHppOpen\RainchasersResponse  $rainchasersResponse
     * @return boolean indicating if level is too high.
     * @author Peter Heywood <peethwd@gmail.com>
     */
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

    /**
     * Autoload function based on Codeguy\Slim https://github.com/codeguy/Slim php's autoload 
     * @param  string $className
     */
    public static function autoload($className){
        $thisClass = str_replace(__NAMESPACE__.'\\', '', __CLASS__);

        $baseDir = __DIR__;

        if (substr($baseDir, -strlen($thisClass)) === $thisClass) {
            $baseDir = substr($baseDir, 0, -strlen($thisClass));
        }

        $className = ltrim($className, '\\');
        $fileName  = $baseDir;
        $namespace = '';
        if ($lastNsPos = strripos($className, '\\')) {
            $namespace = substr($className, 0, $lastNsPos);
            $className = substr($className, $lastNsPos + 1);
            $fileName  .= str_replace('\\', DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
        }
        $fileName .= str_replace('_', DIRECTORY_SEPARATOR, $className) . '.php';

        if (file_exists($fileName)) {
            require $fileName;
        }
    }

    /**
     * Register the class autoloader via spl_autoload_register
     * @author  Peter Heywood <peethwd@gmail.com>
     */
    public static function registerAutoloader(){
        spl_autoload_register(__NAMESPACE__ . "\\IsHppOpen::autoload");
    }
}