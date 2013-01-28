<?php
// App configuration file
//$app["modules"] = array("ctemplate");

$app['route'] = array(
    '/' => 'Front_Controller_Front::homepage',
    '/post/(.+)$' => 'Front_Controller_Front::post',
    '/rss$' => 'Front_Controller_Front::rss',
    );
