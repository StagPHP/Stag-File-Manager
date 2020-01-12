<?php
/**
 * Example to create file on server
 * 
 * For demonstration it will create only text files
 * 
 * Provide get parameter
 *      -> filename: name of the file to be created
 *      -> data: data which needs to be saved in a file */

// Include min controller
include 'dist/main.php';

// ABSPATH must be defined
if(!defined('ABSPATH')) define('ABSPATH', dirname(__FILE__));

/** APP_STARTED Flag to simulate StagPHP framework
 * environment for this script. */
if(!defined('APP_STARTED')) define('APP_STARTED', TRUE);

$file_manager = new stag_file_manager;

$timestamp = (string)round(microtime(true) * 1000);

$result = $file_manager->copy_file('/test/test-file.txt', '/'.$timestamp.'/test-file.txt');

// Var dump the result
var_dump($result);