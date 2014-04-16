<?php

require('../vendor/autoload.php');

$framework = new assegai\Framework();
$framework->run(dirname(__DIR__) . '/conf.php');
