<?php
/**
 * Simple Example
 */

// Include min controller
include 'dist/file-manager.php';

// ABSPATH must be defined
if(!defined('ABSPATH')) define('ABSPATH', dirname(__FILE__));

/** APP_STARTED Flag to simulate StagPHP framework
 * environment for this script. */
if(!defined('APP_STARTED')) define('APP_STARTED', TRUE);

// Create new file manger instance
$file_manager = new stag_file_manager;

// Check is the folder writable
$result = $file_manager->scan_directory('/test/', TRUE);

// Output - var dump the result
var_dump($result);