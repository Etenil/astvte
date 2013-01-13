<?php
// App configuration file
//$app["modules"] = array("ctemplate");

$app['route'] = array(
    '/' => 'Front_Controller_Front::homepage',
    '/post/(\d+)$' => 'Front_Controller_Front::post',
    );
