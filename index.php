<?php
    /**
     * Example usage of is-hpp-open.
     * @author Peter Heywood
     * @version 0.1.0
     */
    $ans = null;
    $ansStr = null;
    $ansClass = null;
    // Require main class.
    require_once("IsHppOpen/IsHppOpen.php");
    \IsHppOpen\IsHppOpen::registerAutoloader();

    $isHppOpen = new \IsHppOpen\IsHppOpen();
    $ans = $isHppOpen->check();

    if($ans){
        $ansStr = "probably";
        $ansClass = "alert-success";
    } else {
        $ansStr = "probably not";
        $ansClass = "alert-danger";
    }
    $cutOffHeight = $isHppOpen->getConfigCutOffHeight();
    $riverObj = $isHppOpen->getRiverData();


?>
<!DOCTYPE html>
<html>
    <head>
        <title>Is HPP Open? | peethwd.net</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- Bootstrap via cdn -->
        <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css">
        <script src="//netdna.bootstrapcdn.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>

        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
        <style>
        html, body {
            background: #ffffff;
        }
        body {
            margin-top: 5%;
        }

        .credit {
            padding: 0.5%;
            color: #999;
        }
        .rainchasers-credit {
            color: #999;
            padding-bottom: 1%;
        }
        .btn-dark {
            color: #ccc;
            background-color: #555;
            border-color: #CCC;
        }
        .btn-dark:hover {
            color: #ccc;
            background-color: #333;
            border-color: #CCC;
        }
        .ans {
            font-size: 130%;
        }
        .explanation {
            margin-top: 5%;
            font-size: 90%;
            color: #999;
        }
        .explanation a,
        .explanation a:hover {
            color: #87AECF;
        }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-md-8 col-md-offset-2">
                    <div class="well text-center">
                        <h1 id="is-hpp-open">Is HPP open?</h1>
                        <div class="alert <?php echo $ansClass;?> ans">
                            HPP is <strong><?php echo strtoupper($ansStr);?> open</strong>
                        </div>
                        <div class="explanation">
                            The level at <strong><a href="http://www.environment-agency.gov.uk/homeandleisure/floods/riverlevels/120752.aspx?stationId=2102" target="_blank">Colwick</a></strong> is currently <strong><?php echo $riverObj->getEaLevel();?>m</strong>.
                            <br />
                            If the level is above <strong><?php echo $cutOffHeight;?>m</strong> then the river is probably too high for the course to be open. 
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-md-8 col-md-offset-2">
                    <hr />
                    <ul class="credit text-center list-inline">
                        <li>
                            Created by <a href="http://twitter.com/peethwd" class="btn btn-small btn-primary">@peethwd</a>
                        </li>
                        <li>
                            View on <a href="https://github.com/peethwd/is-hpp-open" class="btn btn-small btn-default btn-dark">Github</a>
                        </li>
                    </ul>
                    <div class="text-center rainchasers-credit">
                            <div xmlns:cc="http://creativecommons.org/ns#" xmlns:dct="http://purl.org/dc/terms/" about="http://developer.rainchasers.com/"><span property="dct:title">Rainchasers Dataset</span> (<a rel="cc:attributionURL" property="cc:attributionName" href="http://rainchasers.com">rainchasers.com</a>) / <a rel="license" href="http://creativecommons.org/licenses/by/3.0/">CC BY 3.0</a></div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
