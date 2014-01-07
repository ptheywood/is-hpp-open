<?php
/**
 * Example usage of is-hpp-open.
 * @author Peter Heywood
 * @version 0.1.0
 */

// Require main class.
require("is-hpp-open/IsHppOpen.php");

// Instanciate
$isHppOpen = new IsHppOpen();

// Check if the course will be open.
var_dump( $isHppOpen->check() );

// Check while returning string formatted output
var_dump( $isHppOpen->check(true) );
