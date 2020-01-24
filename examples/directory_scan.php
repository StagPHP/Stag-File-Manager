<?php
/**
 * Simple Example to scan a directory
 */

// Create new file manger instance
$file_manager = new stag_file_manager('/examples');

// Check is the folder writable
$directory_content = $file_manager->scan_directory([
    'directory' => '/'
]);

// Output - var dump the result
echo '<div><p>Directory content: </p><table><tr><td><b>KEY</b></td><td><b>VALUE</b></td><td><b>TYPE</b></td></tr>';
foreach($directory_content as $key => $value) echo '<tr><td>'.$key.'</td><td>'.var_export($value, TRUE).'</td><td>'.gettype($value).'</td></tr>';
echo '</table></div>';