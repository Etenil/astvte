<?php
// App configuration file
//$app["modules"] = array("ctemplate");

$app['route'] = array(
// Front facing stuff
    '/' => 'astvte\\controllers\\Front::homepage',
    '/post/(.+)$' => 'astvte\\controllers\\Front::post',
    '/rss$' => 'astvte\\controllers\\Front::rss',
	
// Admin stuff
    '/cms' => 'astvte\\controllers\\Post::listAll',
    'GET:/cms/post/add' => 'astvte\\controllers\\Post::write',
    'POST:/cms/post/add' => 'astvte\\controllers\\Post::add',
    'GET:/cms/post/edit/(.+)' => 'astvte\\controllers\\Post::edit',
    'POST:/cms/post/edit/(.+)' => 'astvte\\controllers\\Post::change',
// Login
    'GET:/cms/login' => 'astvte\\controllers\\Login::login',
    'POST:/cms/login' => 'astvte\\controllers\\Login::doLogin',
);

$app['modules'] = array(
	'redbean',
	'markdown',
);

$app['use_session'] = true;

require('blog.conf.php');
