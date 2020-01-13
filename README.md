
# Stag File Manager

Stag File Manager is the part of StagPHP framework core library. This can also be used as a standalone library for your custom PHP project. You just need to follow the instructions given below. Composer support coming soon.

- This library is capable of doing several complex file operation smoothly. Such as recursive copy, move, delete etc.
- It is tested and compatible with **Linux**, **Windows** and **Unix** environment.
- It is also compatible with latest PHP version 7.x.x

## Installation

### On StagPHP
You don't need to install anything to use this library in your StagPHP application. Its comes built-in. You just need to attach it on your script. Initialize the object of stag_file_manager class. And call the methods from the object. Tutorials will be updated soon.

### On another PHP framework
It is really simple, no brainer. Just include the file in your script and initialize the object of stag_file_manager class. And call the methods from the object.
1. First, you need to copy the files inside the dist (distribution) folder to your project folder. Include stag-file-manager.php in your PHP script or application at a root level.
2. Define ABSPATH in your root level script.
```PHP
if(!defined('ABSPATH')) define('ABSPATH',  dirname(__FILE__));
```
4. After including the file, initialize the object of stag_file manager class.
5. Use the object Initialized, to manage files and folder using the methods listed below.


## Stag File Manager Operations
### Lists of Native Methods:
|Method Name					 |Explanation				|
|:-------------------------------|:-------------------------|
|[Get  info](#get-file-or-directory-info)|Retuns information about the file or directory|
|[Scan directory](#scan-directory)|Scan the directory for files and folders|
|[Update file](#create-or-update-file)|Updates the file and creates it if does not exists|
|[Copy file](#copy-file)|Creates a copy of a file|
|[Move File](#copy-file)|Move file to another location|
|[Delete File](#copy-file)|Delets the file permanently|
|[Create Directory](#copy-file)|Creates a empty directory|
|[Copy Directory](#copy-file)|Create a copy of the directory (**recursively**)|
|[Move Directory](#copy-file)|Move directory to another location (**recursively**)|
|[Delete Directory](#copy-file)|Delets the directory permanently (**recursively**)|

### Lists of Hacks:
|Hacks					 		 |Explanation				|
|:-------------------------------|:-------------------------|
|[Rename file](#rename-file)|Retuns information about the file or directory|
|[Rename Directory](#rename-directory)|Updates the file and creates it if does not exists|
|[Move to trash](#move-to-trash)|Move files and directories to trash|

# Get File or Directory Info
```PHP
$file_manager  =  new  stag_file_manager;

/** 
 * Basic Information about file
 * 
 * Get the basic information of the test.file.extension
 * file.
 * 
 * @returns: array - status, type, is_writable */
$basic_info = $file_manager->get_info('/test.file.extension', FALSE);

/** 
 * Complete Information about file
 * 
 * Get the complete information of the test.file.extension
 * file. As this method checks for multiple parameters,
 * it takes more resourse and time for execution than
 * the previous method.
 * 
 * @returns: array - status, type, is_writable,
 * mime_type, permission, modified_time */
$full_info = $file_manager->get_info('/test.file.extension', TRUE);

/** 
 * Complete Information about directory
 * 
 * Just pass directory path in place of file path */
$full_info = $file_manager->get_info('/test-directory/', TRUE);
```

## Parameters to be passed:
|Parameter						 |Explanation				|
|:-------------------------------|:-------------------------|
|Relative path of a file or directory|Must be relative to root|
|Detailed Information Flag (**Boolean**) |Must be only **TRUE** or **FALSE**|

## Array of values returned after execution:
|Returned keys					 |Explanation 				|
|:-------------------------------|:-------------------------|
|status			|In boolean, **TRUE** if file exists|
|type			|**file** or **directory** depending upon the argument passed|
|is_writable	|In boolean, **TRUE** if file is writable|
|mime_type 		|View [MIME Types](https://en.wikipedia.org/wiki/Media_type) (**inode/directory** in case of directory)|
|permission		|File permissions in a octal numbers [more info](https://www.php.net/manual/en/function.fileperms.php).|
|modified_time	|Last modified time of a file or directory **YYYY-12-30 24:60:60**|

# Scan Directory
```PHP
$file_manager  =  new  stag_file_manager;

/** 
 * Scan directory
 * 
 * This method scans the directory on the level
 * specified. For sub directory, you can call the
 * method again. method is restricted to the single
 * level to boost performance.
 * 
 * @returns: array - status, array of files,
 * array of directories */
$result = $file_manager->scan_directory('/test/');
```
## Parameters to be passed:
|Parameter						 |Explanation				|
|:-------------------------------|:-------------------------|
|Relative path of a file or directory|Must be relative to root|

## Array of values returned after execution:
|Returned keys		|Explanation 	|
|------------------------------|---------------------------|
|status			|In boolean, **TRUE** if directory exists|
|directories	|Array of directory names|
|files			|Array of file names with example|

# Create or Update File
```PHP
$file_manager  =  new  stag_file_manager;

/** 
 * Update File
 * 
 * This method scans the directory on the level
 * specified. For sub directory, you can call the
 * method again. method is restricted to the single
 * level to boost performance.
 * 
 * @returns: array - status, array of files,
 * array of directories */
$result = $file_manager->update_file('/loc/'.$file_name, $file_content);
```
## Parameters to be passed:
|Parameter						 |Explanation				|
|:-------------------------------|:-------------------------|
|Relative path of a file (**string**)|Path of the file, which needs to be updated or where it needs to be created. Must be relative to root|
|File content (**string**)|File content|

## Array of values returned after execution:
|Returned keys					|Explanation 				 |
|:------------------------------|:---------------------------|
|status (**boolean**) |In boolean, **TRUE** if operation was successful|
|description (**string**) |Textual  description of te operation. Error message in case of failure|

# Copy File
```PHP
$file_manager  =  new  stag_file_manager;

/** 
 * Copy File
 * 
 * This method scans the directory on the level
 * specified. For sub directory, you can call the
 * method again. method is restricted to the single
 * level to boost performance.
 * 
 * @returns: array - status, array of files,
 * array of directories */
$result = $file_manager->copy_file('/loc-1/'.$file_name, '/loc-2/'.$file_name);
```
## Parameters to be passed:
|Parameter						 |Explanation				|
|:-------------------------------|:-------------------------|
|Relative path of a file (**string**)|Path of the file, which needs to be updated or where it needs to be created. Must be relative to root|
|File content (**string**)|File content|

## Array of values returned after execution:
|Returned keys					|Explanation 				 |
|:------------------------------|:---------------------------|
|status (**boolean**) |In boolean, **TRUE** if operation was successful|
|description (**string**) |Textual  description of te operation. Error message in case of failure|