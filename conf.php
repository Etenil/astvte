<?php

if(file_exists(__DIR__ . '/prefix'))
    $conf['prefix'] = file_get_contents(__DIR__ . '/prefix');

$conf['apps_path'] = __DIR__ . '/apps';
$conf['models_path'] = __DIR__ . '/models';
$conf['user_modules'] = __DIR__ . '/modules';

$conf['apps'] = array(
    'front',
    'back',
    );

$conf['modules'] = array(
    'redbean',
    'markdown'
    );

$conf['redbean'] = array(
    'dsn' => 'mysql:host=localhost;dbname=ezblog',
    'user' => 'root',
    'pass' => 'gandalf');

$conf['markdown'] = array(
    'type' => 'extra',
    );

$conf['password'] = 'admin';
