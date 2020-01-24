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
            include 'examples/get-info.php';
            $list_visible = FALSE;
            break;
        case 2:
            include 'examples/get-file-properties.php';
            $list_visible = FALSE;
            break;
        case 3:
            include 'examples/get-directory-properties.php';
            $list_visible = FALSE;
            break;
        case 4:
            include 'examples/directory_scan.php';
            $list_visible = FALSE;
            break;
        case 5:
            include 'examples/deep_directory_scan.php';
            $list_visible = FALSE;
            break;
        case 6:
            include 'examples/create-file.php';
            $list_visible = FALSE;
            break;
        case 7:
            include 'examples/update-file.php';
            $list_visible = FALSE;
            break;
        case 8:
            include 'examples/copy-file.php';
            $list_visible = FALSE;
            break;
        case 9:
            include 'examples/move-file.php';
            $list_visible = FALSE;
            break;
        case 10:
            include 'examples/rename-file.php';
            $list_visible = FALSE;
            break;
        case 11:
            include 'examples/delete-file.php';
            $list_visible = FALSE;
            break;
        case 12:
            include 'examples/create-directory.php';
            $list_visible = FALSE;
            break;
        case 13:
            include 'examples/copy-directory.php';
            $list_visible = FALSE;
            break;
        case 14:
            include 'examples/move-directory.php';
            $list_visible = FALSE;
            break;
        case 15:
            include 'examples/rename-directory.php';
            $list_visible = FALSE;
            break;
        case 16:
            include 'examples/delete-directory.php';
            $list_visible = FALSE;
            break;
        case 17:
            include 'examples/download-file.php';
            $list_visible = FALSE;
            break;
        case 18:
            include 'examples/get-remote-file-content.php';
            $list_visible = FALSE;
            break;
        case 19:
            include 'examples/zip-file.php';
            $list_visible = FALSE;
            break;
        case 20:
            include 'examples/extract-file.php';
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
        <div  style="padding: 0px;">
            <div style="padding: 20px; border-bottom: 1px solid #ddd;">
                <a href="<?php echo 'http://'.$_SERVER['HTTP_HOST'].$uri_parts[0].'?example=1'; ?>" target="_blank">Example: Get Basic Info</a>
            </div>
        </div>
        <div  style="padding: 0px;">
            <div style="padding: 20px; border-bottom: 1px solid #ddd;">
                <a href="<?php echo 'http://'.$_SERVER['HTTP_HOST'].$uri_parts[0].'?example=2'; ?>" target="_blank">Example: Get File Properties</a>
            </div>
        </div>
        <div  style="padding: 0px;">
            <div style="padding: 20px; border-bottom: 1px solid #ddd;">
                <a href="<?php echo 'http://'.$_SERVER['HTTP_HOST'].$uri_parts[0].'?example=3'; ?>" target="_blank">Example: Get Directory Properties</a>
            </div>
        </div>
        <div  style="padding: 0px;">
            <div style="padding: 20px; border-bottom: 1px solid #ddd;">
                <a href="<?php echo 'http://'.$_SERVER['HTTP_HOST'].$uri_parts[0].'?example=4'; ?>" target="_blank">Example: Directory Scan</a>
            </div>
        </div>
        <div  style="padding: 0px;">
            <div style="padding: 20px; border-bottom: 1px solid #ddd;">
                <a href="<?php echo 'http://'.$_SERVER['HTTP_HOST'].$uri_parts[0].'?example=5'; ?>" target="_blank">Example: Deep Directory Scan</a>
            </div>
        </div>
        <div  style="padding: 0px;">
            <div style="padding: 20px; border-bottom: 1px solid #ddd;">
                <a href="<?php echo 'http://'.$_SERVER['HTTP_HOST'].$uri_parts[0].'?example=6'; ?>" target="_blank">Example: Create File</a>
            </div>
        </div>
        <div  style="padding: 0px;">
            <div style="padding: 20px; border-bottom: 1px solid #ddd;">
                <a href="<?php echo 'http://'.$_SERVER['HTTP_HOST'].$uri_parts[0].'?example=7'; ?>" target="_blank">Example: Update File</a>
            </div>
        </div>
        <div  style="padding: 0px;">
            <div style="padding: 20px; border-bottom: 1px solid #ddd;">
                <a href="<?php echo 'http://'.$_SERVER['HTTP_HOST'].$uri_parts[0].'?example=8'; ?>" target="_blank">Example: Copy File</a>
            </div>
        </div>
        <div  style="padding: 0px;">
            <div style="padding: 20px; border-bottom: 1px solid #ddd;">
                <a href="<?php echo 'http://'.$_SERVER['HTTP_HOST'].$uri_parts[0].'?example=9'; ?>" target="_blank">Example: Move File</a>
            </div>
        </div>
        <div  style="padding: 0px;">
            <div style="padding: 20px; border-bottom: 1px solid #ddd;">
                <a href="<?php echo 'http://'.$_SERVER['HTTP_HOST'].$uri_parts[0].'?example=10'; ?>" target="_blank">Example: Rename File</a>
            </div>
        </div>
        <div  style="padding: 0px;">
            <div style="padding: 20px; border-bottom: 1px solid #ddd;">
                <a href="<?php echo 'http://'.$_SERVER['HTTP_HOST'].$uri_parts[0].'?example=11'; ?>" target="_blank">Example: Delete File</a>
            </div>
        </div>
        <div style="padding: 0px;">
            <div style="padding: 20px; border-bottom: 1px solid #ddd;">
                <a href="<?php echo 'http://'.$_SERVER['HTTP_HOST'].$uri_parts[0].'?example=12'; ?>" target="_blank">Example: Create Directory</a>
            </div>
        </div>
        <div style="padding: 0px;">
            <div style="padding: 20px; border-bottom: 1px solid #ddd;">
                <a href="<?php echo 'http://'.$_SERVER['HTTP_HOST'].$uri_parts[0].'?example=13'; ?>" target="_blank">Example: Copy Directory</a>
            </div>
        </div>
        <div style="padding: 0px;">
            <div style="padding: 20px; border-bottom: 1px solid #ddd;">
                <a href="<?php echo 'http://'.$_SERVER['HTTP_HOST'].$uri_parts[0].'?example=14'; ?>" target="_blank">Example: Move Directory</a>
            </div>
        </div>
        <div style="padding: 0px;">
            <div style="padding: 20px; border-bottom: 1px solid #ddd;">
                <a href="<?php echo 'http://'.$_SERVER['HTTP_HOST'].$uri_parts[0].'?example=15'; ?>" target="_blank">Example: Rename Directory</a>
            </div>
        </div>
        <div style="padding: 0px;">
            <div style="padding: 20px; border-bottom: 1px solid #ddd;">
                <a href="<?php echo 'http://'.$_SERVER['HTTP_HOST'].$uri_parts[0].'?example=16'; ?>" target="_blank">Example: Delete Directory</a>
            </div>
        </div>
        <div style="padding: 0px;">
            <div style="padding: 20px; border-bottom: 1px solid #ddd;">
                <a href="<?php echo 'http://'.$_SERVER['HTTP_HOST'].$uri_parts[0].'?example=17'; ?>" target="_blank">Example: Download File</a>
            </div>
        </div>
        <div style="padding: 0px;">
            <div style="border-bottom: 1px solid #ddd;">
                <a href="<?php echo 'http://'.$_SERVER['HTTP_HOST'].$uri_parts[0].'?example=18'; ?>" target="_blank">Example: Get Remote File Content</a>
            </div>
        </div>
        <div style="padding: 0px;">
            <div style="border-bottom: 1px solid #ddd;">
                <a href="<?php echo 'http://'.$_SERVER['HTTP_HOST'].$uri_parts[0].'?example=19'; ?>" target="_blank">Example: Create zip of a file</a>
            </div>
        </div>
        <div style="padding: 0px;">
            <div style="border-bottom: 1px solid #ddd;">
                <a href="<?php echo 'http://'.$_SERVER['HTTP_HOST'].$uri_parts[0].'?example=20'; ?>" target="_blank">Example: Extract zip file</a>
            </div>
        </div>
        <?php endif; ?>
    </body>
</html>