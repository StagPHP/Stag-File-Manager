<?php
/**
 * Simple Example to create a file
 */

// Create new file manger instance
$file_manager = new stag_file_manager('/examples');

$src_dir = '/test/';

$dest_dir = '/moved-files/';

// Check is the folder writable
$result = $file_manager->copy_directory(array(
    'directory'             => $src_dir,            // Directory location where file will be created
    'destination_directory' => $dest_dir,           // File content
    'merge_directory'       => FALSE,               // By default create directory flag assumed false
    'overwrite_file'        => FALSE                // By default create file flag assumed false
));

// Output - var dump the result
echo '<div><p>File Creation Result: </p><table><tr><td><b>KEY</b></td><td><b>VALUE</b></td><td><b>TYPE</b></td></tr>';
foreach($result as $key => $value) echo '<tr><td>'.$key.'</td><td>'.var_export($value, TRUE).'</td><td>'.gettype($value).'</td></tr>';
echo '</table></div>';