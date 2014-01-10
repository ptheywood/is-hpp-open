is-hpp-open
===========

Check if the River Trent is too high to be open or not via api.rainchasers.com.

This simply estimates if teh course will be open by assuming that above a level of 2.00m at the [Colwick River Guage](http://www.environment-agency.gov.uk/homeandleisure/floods/riverlevels/120752.aspx?stationId=2102) on the River Trent.

Configuration
-------------
Configuration is handled via [IsHppOpen/config.ini](https://github.com/peethwd/is-hpp-open/blob/master/IsHppOpen/config.ini)

Users should define a useragent string for their application in accordance with the [rainchasers API](http://developer.rainchasers.com/#api).

It is also possible to set values used by teh application, to point it to another river via ```trent-uuid```, or change the ```cut-off-height``` to alter when river level decisions are made. 


Usage
-----

    // Require main class.
    require_once("IsHppOpen/IsHppOpen.php");
    // Register the autoloader if required.
    \IsHppOpen\IsHppOpen::registerAutoloader();

    // Instanciate
    $isHppOpen = new \IsHppOpen\IsHppOpen();

It is then possible to check the level in a variety of ways:

    $booleanResponse = $isHppOpen->check();

Where $booleanResponse would be ```true``` or ```false```.

    $stringResponse = $isHppOpen->check(true);

Where $booleanResponse would be a vaguely phrased string ```Probably``` or ```Probably not```.

See [examples.php](https://github.com/peethwd/is-hpp-open/blob/master/examples.php)


Licencing 
---------
is-hpp-open source code & examples are licenced under The MIT License (MIT) & Copyright (c) 2014 Peter Heywood (see [LICENCE](https://github.com/peethwd/is-hpp-open/blob/master/LICENSE]) )

Rainchasers Dataset by rainchasers.com is licensed under a Creative Commons Attribution 3.0 Unported License.
http://creativecommons.org/licenses/by/3.0/legalcode


