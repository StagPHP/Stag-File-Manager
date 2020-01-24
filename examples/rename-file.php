<?php
/**
 * Simple Example to create a file
 */

// Create new file manger instance
$file_manager = new stag_file_manager('/examples');

$old_filename = 'zip-file-moved.php';
$new_filename = 'zip-file-moved.php';

// Check is the folder writable
$result = $file_manager->rename_file(array(
    'directory'             => '/test/moved-files/',            // Directory location where file will be created
    'file_name'             => $old_filename,       // Name of the file
    'new_file_name'         => $new_filename,       // File content
    'overwrite_file'        => TRUE              // By default create file flag assumed false
));

// Output - var dump the result
echo '<div><p>File Creation Result: </p><table><tr><td><b>KEY</b></td><td><b>VALUE</b></td><td><b>TYPE</b></td></tr>';
foreach($result as $key => $value) echo '<tr><td>'.$key.'</td><td>'.var_export($value, TRUE).'</td><td>'.gettype($value).'</td></tr>';
echo '</table></div>';