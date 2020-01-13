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
include 'dist/file-manager.php';

// ABSPATH must be defined
if(!defined('ABSPATH')) define('ABSPATH', dirname(__FILE__));

/** APP_STARTED Flag to simulate StagPHP framework
 * environment for this script. */
if(!defined('APP_STARTED')) define('APP_STARTED', TRUE);

/** Check for the get parameters */
if(!empty($_GET['filename']) && !empty($_GET['data'])){
    $file_name = $_GET['filename'].'.txt';
    $file_content = $_GET['data'];

    $file_manager = new stag_file_manager;

    $result = $file_manager->update_file(
        '/test/'.$file_name,
        $file_content
    );

    // Var dump the result
    var_dump($result);
}

/** Error response */
else {
    echo 'File name or data not specified!';
    exit;
}