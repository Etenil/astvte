<?php

if(file_exists(__DIR__ . '/prefix'))
    $conf['prefix'] = trim(file_get_contents(__DIR__ . '/prefix'));

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

$conf['redbean'] = array(
    'dsn' => 'mysql:host=localhost;dbname=ezblog',
    'user' => 'ezblog',
    'pass' => 'ezblog',
    );

$conf['markdown'] = array(
    'type' => 'extra',
    );

require(__DIR__ . '/blog.conf.php');
