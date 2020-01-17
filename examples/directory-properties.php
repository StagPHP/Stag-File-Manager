<?php
/**
 * Simple Example to get basic info
 */

// Create new file manger instance
$file_manager = new stag_file_manager;

// Check is the folder writable
$file_info = $file_manager->get_directory_properties('/examples/');

// Output - var dump the result
echo '<div><p>File Basic Info: </p><table><tr><td><b>KEY</b></td><td><b>VALUE</b></td><td><b>TYPE</b></td></tr>';
foreach($file_info as $key => $value) echo '<tr><td>'.$key.'</td><td>'.var_export($value, TRUE).'</td><td>'.gettype($value).'</td></tr>';
echo '</table></div>';