<?php
/**
 * This file is used to demonstrate the functionality
 * of SragPHP File Manager */

// ABSPATH must be defined
if(!defined('ABSPATH')) define('ABSPATH', dirname(__FILE__));

// Include main controller
include 'dist/stag-file-manager.php';

$list_visible = TRUE;

if(!empty($_GET['example'])){
    switch((int)$_GET['example']) {
        case 1:
            include 'examples/1-get-basic-info.php';
            $list_visible = FALSE;
            break;
        case 2:
            include 'examples/2-get-detailed-info.php';
            $list_visible = FALSE;
            break;
        case 3:
            include 'examples/3.-scan-directory.php';
            $list_visible = FALSE;
            break;
    }
} 

$uri_parts = explode('?', $_SERVER['REQUEST_URI'], 2); ?>

<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>SragPHP File Manager Example</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="">
    </head>
    <body>
        <?php if($list_visible): ?>
        <div>
            <div style="padding: 20px; border-bottom: 1px solid #ddd;">
                <a style="text-decoration: none;" href="<?php echo 'http://'.$_SERVER['HTTP_HOST'].$uri_parts[0].'?example=1'; ?>" target="_blank">1. Example: Get Basic Info</a>
            </div>
        </div>
        <div>
            <div style="padding: 20px; border-bottom: 1px solid #ddd;">
                <a style="text-decoration: none;" href="<?php echo 'http://'.$_SERVER['HTTP_HOST'].$uri_parts[0].'?example=2'; ?>" target="_blank">2. Example: Get Detailed Info</a>
            </div>
        </div>
        <div>
            <div style="padding: 20px; border-bottom: 1px solid #ddd;">
                <a style="text-decoration: none;" href="<?php echo 'http://'.$_SERVER['HTTP_HOST'].$uri_parts[0].'?example=3'; ?>" target="_blank">3. Example: Scan Directory</a>
            </div>
        </div>
        <?php endif; ?>
    </body>
</html>