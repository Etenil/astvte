<?php
// App configuration file
//$app["modules"] = array("ctemplate");

$app['route'] = array(
    '/cms' => 'Back_Controller_Post::listAll',
    'GET:/cms/post/add' => 'Back_Controller_Post::write',
    'POST:/cms/post/add' => 'Back_Controller_Post::add',
    'GET:/cms/post/edit/(.+)' => 'Back_Controller_Post::edit',
    'POST:/cms/post/edit/(.+)' => 'Back_Controller_Post::change',
// Login
    'GET:/cms/login' => 'Back_Controller_Login::login',
    'POST:/cms/login' => 'Back_Controller_Login::doLogin',
    );

$app['modules'] => array(
    'validator',
);