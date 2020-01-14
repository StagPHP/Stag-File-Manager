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
            include 'examples/3-scan-directory.php';
            $list_visible = FALSE;
            break;
        case 4:
            include 'examples/4-create-file.php';
            $list_visible = FALSE;
            break;
        case 5:
            include 'examples/5-update-file.php';
            $list_visible = FALSE;
            break;
        case 6:
            include 'examples/6-copy-file.php';
            $list_visible = FALSE;
            break;
        case 7:
            include 'examples/7-move-file.phpp';
            $list_visible = FALSE;
            break;
        case 8:
            include 'examples/8-delete-file.php';
            $list_visible = FALSE;
            break;
        case 9:
            include 'examples/9-create-directory.php';
            $list_visible = FALSE;
            break;
        case 10:
            include 'examples/10-copy-directory.php';
            $list_visible = FALSE;
            break;
        case 11:
            include 'examples/11-move-directory.php';
            $list_visible = FALSE;
            break;
        case 12:
            include 'examples/12-delete-directory.php';
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
        <style>
            body{
                padding: 0;
                margin: 0;
                font-family: Arial, "Helvetica Neue", Helvetica, sans-serif;
                color: #555;
            }
            a{
                color: #444;
                text-decoration: none;
            }
            a:hover{
                color: #87C540;
                text-decoration: none;
            }
            table, th, td {
                border: 1px solid black;
            }
            td {
                padding: 5px 10px;
            }
            div{
                padding: 20px;
            }
        </style>
    </head>
    <body>
        <?php if($list_visible): ?>
        <div>
            <div style="padding: 20px; border-bottom: 1px solid #ddd;">
                <a href="<?php echo 'http://'.$_SERVER['HTTP_HOST'].$uri_parts[0].'?example=1'; ?>" target="_blank">1. Example: Get Basic Info</a>
            </div>
        </div>
        <div>
            <div style="padding: 20px; border-bottom: 1px solid #ddd;">
                <a href="<?php echo 'http://'.$_SERVER['HTTP_HOST'].$uri_parts[0].'?example=2'; ?>" target="_blank">2. Example: Get Detailed Info</a>
            </div>
        </div>
        <div>
            <div style="padding: 20px; border-bottom: 1px solid #ddd;">
                <a href="<?php echo 'http://'.$_SERVER['HTTP_HOST'].$uri_parts[0].'?example=3'; ?>" target="_blank">3. Example: Scan Directory</a>
            </div>
        </div>
        <div>
            <div style="padding: 20px; border-bottom: 1px solid #ddd;">
                <a href="<?php echo 'http://'.$_SERVER['HTTP_HOST'].$uri_parts[0].'?example=4'; ?>" target="_blank">4. Example: Create File</a>
            </div>
        </div>
        <div>
            <div style="padding: 20px; border-bottom: 1px solid #ddd;">
                <a href="<?php echo 'http://'.$_SERVER['HTTP_HOST'].$uri_parts[0].'?example=5'; ?>" target="_blank">5. Example: Update File</a>
            </div>
        </div>
        <div>
            <div style="padding: 20px; border-bottom: 1px solid #ddd;">
                <a href="<?php echo 'http://'.$_SERVER['HTTP_HOST'].$uri_parts[0].'?example=6'; ?>" target="_blank">6. Example: Copy File</a>
            </div>
        </div>
        <div>
            <div style="padding: 20px; border-bottom: 1px solid #ddd;">
                <a href="<?php echo 'http://'.$_SERVER['HTTP_HOST'].$uri_parts[0].'?example=7'; ?>" target="_blank">7. Example: Move File</a>
            </div>
        </div>
        <div>
            <div style="padding: 20px; border-bottom: 1px solid #ddd;">
                <a href="<?php echo 'http://'.$_SERVER['HTTP_HOST'].$uri_parts[0].'?example=8'; ?>" target="_blank">8. Example: Delete File</a>
            </div>
        </div>
        <div>
            <div style="padding: 20px; border-bottom: 1px solid #ddd;">
                <a href="<?php echo 'http://'.$_SERVER['HTTP_HOST'].$uri_parts[0].'?example=9'; ?>" target="_blank">9. Example: Create Directory</a>
            </div>
        </div>
        <div>
            <div style="padding: 20px; border-bottom: 1px solid #ddd;">
                <a href="<?php echo 'http://'.$_SERVER['HTTP_HOST'].$uri_parts[0].'?example=10'; ?>" target="_blank">10. Example: Copy Directory</a>
            </div>
        </div>
        <div>
            <div style="padding: 20px; border-bottom: 1px solid #ddd;">
                <a href="<?php echo 'http://'.$_SERVER['HTTP_HOST'].$uri_parts[0].'?example=11'; ?>" target="_blank">11. Example: Move Directory</a>
            </div>
        </div>
        <div>
            <div style="padding: 20px; border-bottom: 1px solid #ddd;">
                <a href="<?php echo 'http://'.$_SERVER['HTTP_HOST'].$uri_parts[0].'?example=12'; ?>" target="_blank">12. Example: Delete Directory</a>
            </div>
        </div>
        <?php endif; ?>
    </body>
</html>