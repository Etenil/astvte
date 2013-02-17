<?php

$conf['apps_path'] = __DIR__ . '/apps';
$conf['models_path'] = __DIR__ . '/models';
$conf['user_modules'] = __DIR__ . '/modules';

$conf['apps'] = array(
    'front',
    'back',
    );

$conf['modules'] = array(
    'markdown',
    'redbean'
    );

$conf['markdown'] = array(
    'type' => 'extra',
    );

require(__DIR__ . '/blog.conf.php');
