<?php

include 'dist/main.php';

if(!defined('ABSPATH')) define('ABSPATH', dirname(__FILE__));

if(!defined('APP_STARTED')) define('APP_STARTED', TRUE);

if(!empty($_GET['filename']) && !empty($_GET['data'])){
    $file_name = $_GET['filename'].'.txt';
    $file_content = $_GET['data'];

    $file_operator = new stag_file_operator;

    $result = $file_operator->update_file(
        '/test/test-sub-folder/'.$file_name,
        $file_content,
        TRUE
    );

    var_dump($result);
} else {
    echo 'File name or data not specified!';
    exit;
}