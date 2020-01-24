<?php
/**
 * Simple Example to create a file
 */

// Create new file manger instance
$file_manager = new stag_file_manager('/examples');

$filename = 'new-file.txt';

$file_content = 'This is new file, created on '.date("Y-m-d H:i:s").' UTC';

// Check is the folder writable
$result = $file_manager->create_file(array(
    'directory'             => '/test/',        // Directory location where file will be created
    'file_name'             => $filename,       // Name of the file
    'file_content'          => $file_content,   // File content
    'create_directories'    => TRUE             // By default create directory flag assumed false
));

// Output - var dump the result
echo '<div><p>File Creation Result: </p><table><tr><td><b>KEY</b></td><td><b>VALUE</b></td><td><b>TYPE</b></td></tr>';
foreach($result as $key => $value) echo '<tr><td>'.$key.'</td><td>'.var_export($value, TRUE).'</td><td>'.gettype($value).'</td></tr>';
echo '</table></div>';