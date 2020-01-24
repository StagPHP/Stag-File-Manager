<?php
/**
 * Simple Example to create a file
 */

// Create new file manger instance
$file_manager = new stag_file_manager('/examples');

$filename = 'zip-file-copied.php';

$dest_directory = '/test/moved-files/';

// Check is the folder writable
$result = $file_manager->move_file(array(
    'directory'             => '/test/',            // Directory location where file will be created
    'file_name'             => $filename,           // Name of the file
    'destination_directory' => $dest_directory,     // File content
    // 'new_file_name'         => 'zip-file-moved.php',
    // 'create_directories'    => TRUE,                // By default create directory flag assumed false
    // 'overwrite_file'        => TRUE              // By default create file flag assumed false
));

// Output - var dump the result
echo '<div><p>File Creation Result: </p><table><tr><td><b>KEY</b></td><td><b>VALUE</b></td><td><b>TYPE</b></td></tr>';
foreach($result as $key => $value) echo '<tr><td>'.$key.'</td><td>'.var_export($value, TRUE).'</td><td>'.gettype($value).'</td></tr>';
echo '</table></div>';