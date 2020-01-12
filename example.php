<?php

include 'dist/main.php';

if(!defined('ABSPATH')) define('ABSPATH', dirname(__FILE__));

if(!defined('APP_STARTED')) define('APP_STARTED', TRUE);

$file_operator = new stag_file_operator;

$result = $file_operator->writeable('/test/');

var_dump($result);

echo '<hr>';

$result = $file_operator->get_permission('/test/');

var_dump($result);