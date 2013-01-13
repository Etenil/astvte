<?php

session_start();

require('../vendor/autoload.php');
$engine = new assegai\Dispatcher(dirname(__DIR__) . '/conf.php');
$engine->serve();
