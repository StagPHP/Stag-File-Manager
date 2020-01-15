# Stag File Manager
![StagPHP File Manager Image](https://stagphp.github.io/stag-file-manager/assets/stag-file-manager.png)
Stag File Manager is the part of StagPHP framework core library. This can also be used as a standalone library (PHP script) for file management, in your custom PHP project. You just need to follow the instructions given below. Composer support coming soon.

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
|[Get  Info](#get-file-or-directory-info)|Returns information about the file or directory|
|[Scan Directory](#scan-directory)|Scan the directory for files and folders|
|[Search File](#searc-file)|Perform REGEX search|
|[Update File](#create-or-update-file)|Updates the file and creates it if does not exists|
|[Copy File](#copy-file)|Creates a copy of a file|
|[Move File](#copy-file)|Move file to another location|
|[Delete File](#delete-file)|Deletes the file permanently|
|[Download File](#download-file)|Download a file from remote URL|
|[Get Remote File Content](#download-file)|Get remote file content from remote URL|
|[Compress File](#compress-file)|Compress file|
|[Extract File](#extract-file)|Extract Zip files|
|[Create Directory](#create-directory)|Creates a empty directory|
|[Copy Directory](#copy-directory)|Create a copy of the directory (**recursively**)|
|[Move Directory](#move-directory)|Move directory to another location (**recursively**)|
|[Delete Directory](#delete-directory)|Deletes the directory permanently (**recursively**)|
|[Compress Directory](#compress-directory)|Compress the directory to Zip file|

### Lists of Hacks:
|Hacks					 		 |Explanation				|
|:-------------------------------|:-------------------------|
|[Rename file](#rename-file)|Returns information about the file or directory|
|[Rename Directory](#rename-directory)|Updates the file and creates it if does not exists|
|[Change file extension](#change-file-extension)|Change the file extension, not type|
|[Move to trash](#move-to-trash)|Move files and directories to trash|

# Get Info
### Basic Information
You can follow the below listed example to get the basic information about the file or directory.
```PHP
$file_manager  =  new  stag_file_manager;

/** 
 * Basic Information about file
 * 
 * @returns: array - status, type, is_writable */
$basic_info = $file_manager->get_info('/filename.extension', FALSE);

/** 
 * Basic Information about directory (just pass
 * directory path in place of file path)
 * 
 * @returns: array - status, type, is_writable */
$basic_info = $file_manager->get_info('/directory/', FALSE);
```
### Parameters to be passed:
|Parameter						 |Explanation				|
|:-------------------------------|:-------------------------|
|Relative path of a file or directory (**string**)|Must be relative to root|
|Detailed Information Flag (**boolean**) |Use **FALSE** for basic information|

### Array of values returned after execution:
|Returned keys					 |Explanation 				|
|:-------------------------------|:-------------------------|
|status	(**boolean**) |In boolean, **TRUE** if file exists|
|type (**string**) |**file** or **directory** depending upon the argument passed|
|is_writable (**boolean**) |In boolean, **TRUE** if file is writable|

---

### Detailed Information
You can follow the below listed example to get the detailed information about the file or directory. As this method checks for multiple parameters, it takes slightly more server resource and execution time than the previous method.
```PHP
$file_manager  =  new  stag_file_manager;

/** 
 * Detailed Information about file
 * 
 * @returns: array - status, type, size,
 * is_writable, permission, modified_time */
$full_info = $file_manager->get_info('/filename.extension', TRUE);

/** 
 * Detailed Information about directory (just pass
 * directory path in place of file path)
 * 
 * @returns: array - status, type, size,
 * is_writable, permission, modified_time */
$full_info = $file_manager->get_info('/directory/', TRUE);
```

### Parameters to be passed:
|Parameter						 |Explanation				|
|:-------------------------------|:-------------------------|
|Relative path of a file or directory (**string**)|Must be relative to root|
|Detailed Information Flag (**boolean**) |Use **TRUE** for Detailed information|

### Array of values returned after execution:
|Returned keys					 |Explanation 				|
|:-------------------------------|:-------------------------|
|status	(**boolean**) |In boolean, **TRUE** if file exists|
|type (**string**) |View [MIME Types](https://en.wikipedia.org/wiki/Media_type) (**inode/directory** in case of directory)|
|size (**integer**) |File or Directory (including sub folders and files) in bytes|
|is_writable (**boolean**) |In boolean, **TRUE** if file is writable|
|permission	(**string**) |File permissions in a octal numbers [more info](https://www.php.net/manual/en/function.fileperms.php).|
|modified_time (**string**) |Last modified time of a file or directory **YYYY-12-30 24:60:60**|

# Scan Directory
You can follow the below listed example to scan directory. This method scans the directory on the level specified. That means, it will not scan the contents of the sub directory inside this directory. For sub directory, you can call this method again. We have restricted the method  to scan only single level in order to boost performance.
```PHP
$file_manager  =  new  stag_file_manager;

/** 
 * Scan directory
 * 
 * @returns: array - status, array of files,
 * array of directories */
$result = $file_manager->scan_directory('/test/');
```
### Parameters to be passed:
|Parameter						 |Explanation				|
|:-------------------------------|:-------------------------|
|Relative path of a file or directory (**string**) |Path must be relative|

### Array of values returned after execution:
|Returned keys					|Explanation 				 |
|:------------------------------|:---------------------------|
|status (**boolean**) |In boolean, **TRUE** if directory exists|
|directories (**string**) |Array of directory names|
|files (**string**) |Array of file names with example|

# Create or Update File
You can follow the below listed example to create a new file or update the existing file. It creates a file when specified file does not exists and updates a file when it exists. This method also creates the directory if does not exists.
```PHP
$file_manager  =  new  stag_file_manager;

/** 
 * Create or Update File
 * 
 * @returns: array - status, array of files,
 * array of directories */
$result = $file_manager->update_file('/directory/'.$file_name, $file_content);
```
### Parameters to be passed:
|Parameter						 |Explanation				|
|:-------------------------------|:-------------------------|
|Relative path of a file (**string**)|Path of the file, which needs to be updated or where it needs to be created. Must be relative to root|
|File content (**string**)|File content|

### Array of values returned after execution:
|Returned keys					|Explanation 				 |
|:------------------------------|:---------------------------|
|status (**boolean**) |In boolean, **TRUE** if operation was successful|
|description (**string**) |Success or Error message in case of failure|

# Copy File
You can follow the below listed example to copy a new file from one directory location to another. This method also creates the directory if does not exists.
```PHP
$file_manager  =  new  stag_file_manager;

/** 
 * Copy File
 * 
 * @returns: array - status, array of files,
 * array of directories */
$result = $file_manager->copy_file('/directory/'.$file_name, '/new-directory/'.$file_name);
```
### Parameters to be passed:
|Parameter						 |Explanation				|
|:-------------------------------|:-------------------------|
|Relative path of a file (**string**)|Path of the file, which needs to be copied|
|Relative path of a file (**string**)|New path of the file, where it needs to be copied|

### Array of values returned after execution:
|Returned keys					|Explanation 				 |
|:------------------------------|:---------------------------|
|status (**boolean**) |In boolean, **TRUE** if operation was successful|
|description (**string**) |Success or Error message in case of failure|

# Move File
You can follow the below listed example to move a file from one directory location to another. This method also creates the directory if does not exists.
```PHP
$file_manager  =  new  stag_file_manager;

/** 
 * Move File
 * 
 * @returns: array - status, array of files,
 * array of directories */
$result = $file_manager->move_file('/directory/'.$file_name, '/new-directory/'.$file_name);
```
### Parameters to be passed:
|Parameter						 |Explanation				|
|:-------------------------------|:-------------------------|
|Relative path of a file (**string**)|Path of the file, which needs to be moved|
|Relative path of a file (**string**)|New path of the file, where it needs to be moved|

### Array of values returned after execution:
|Returned keys					|Explanation 				 |
|:------------------------------|:---------------------------|
|status (**boolean**) |In boolean, **TRUE** if operation was successful|
|description (**string**) |Success or Error message in case of failure|

# Delete File
You can follow the below listed example to delete a file. This operation is nor reversible, so it deletes the file permanently.
```PHP
$file_manager  =  new  stag_file_manager;

/** 
 * Delete File
 * 
 * @returns: array - status, description */
$result = $file_manager->delete_file('/directory/'.$file_name);
```
### Parameters to be passed:
|Parameter						 |Explanation				|
|:-------------------------------|:-------------------------|
|Relative path of a file (**string**)|Path of the file, which needs to be deleted|

### Array of values returned after execution:
|Returned keys					|Explanation 				 |
|:------------------------------|:---------------------------|
|status (**boolean**) |In boolean, **TRUE** if operation was successful|
|description (**string**) |Success or Error message in case of failure|

# Create Directory
You can follow the below listed example to creates a new empty directory. This fails if directory already exists.
```PHP
$file_manager  =  new  stag_file_manager;

/** 
 * Create Directory
 * 
 * @returns: array - status, description */
$result = $file_manager->delete_directory('/new-directory/');
```
### Parameters to be passed:
|Parameter						 |Explanation				|
|:-------------------------------|:-------------------------|
|Relative path of a file (**string**)|Path of the file, which needs to be deleted|

### Array of values returned after execution:
|Returned keys					|Explanation 				 |
|:------------------------------|:---------------------------|
|status (**boolean**) |In boolean, **TRUE** if operation was successful|
|description (**string**) |Success or Error message in case of failure|

# Copy Directory
You can follow the below listed example to copy a existing directory to new location (inside another directory). This is recursive operation. This method also creates the directory if does not exists. 
```PHP
$file_manager  =  new  stag_file_manager;

/** 
 * Copy Directory
 * 
 * @returns: array - status, description */
$result = $file_manager->copy_directory('/directory/', '/new-loc/directory/');
```
### Parameters to be passed:
|Parameter						 |Explanation				|
|:-------------------------------|:-------------------------|
|Directory Path (**string**)|Path of the directory, which needs to be copied|
|Directory Path (**string**)|Path to new location, where directory needs to be copied|

### Array of values returned after execution:
|Returned keys					|Explanation 				 |
|:------------------------------|:---------------------------|
|status (**boolean**) |In boolean, **TRUE** if operation was successful|
|description (**string**) |Success or Error message in case of failure|

# Move Directory
You can follow the below listed example to move a existing directory to new location (inside another directory). This is recursive operation. This method also creates the directory if does not exists.
```PHP
$file_manager  =  new  stag_file_manager;

/** 
 * Move Directory
 * 
 * @returns: array - status, description */
$result = $file_manager->move_directory('/directory/', '/new-loc/directory/');
```
### Parameters to be passed:
|Parameter						 |Explanation				|
|:-------------------------------|:-------------------------|
|Directory Path (**string**)|Path of the directory, which needs to be moved|
|Directory Path (**string**)|Path to new location, where directory needs to be moved|

### Array of values returned after execution:
|Returned keys					|Explanation 				 |
|:------------------------------|:---------------------------|
|status (**boolean**) |In boolean, **TRUE** if operation was successful|
|description (**string**) |Success or Error message in case of failure|

# Delete Directory
You can follow the below listed example to delete a directory. This is recursive operation. This operation is nor reversible, so it deletes the directory and entire files and sub directories permanently inside this directory.
```PHP
$file_manager  =  new  stag_file_manager;

/** 
 * Delete Directory
 * 
 * @returns: array - status, description */
$result = $file_manager->delete_directory('/directory/');
```
### Parameters to be passed:
|Parameter						 |Explanation				|
|:-------------------------------|:-------------------------|
|Directory Path (**string**)|Path of the directory, which needs to be deleted|

### Array of values returned after execution:
|Returned keys					|Explanation 				 |
|:------------------------------|:---------------------------|
|status (**boolean**) |In boolean, **TRUE** if operation was successful|
|description (**string**) |Success or Error message in case of failure|