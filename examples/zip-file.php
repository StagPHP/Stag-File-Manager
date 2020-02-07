<?php
/**
 * Simple Example to create a file
 */

// Create new file manger instance
$file_manager = new stag_file_manager('/examples');

$args = array(
    'directory'             => '/',
    'file_name'             => 'zip-file.php',
    'destination_directory' => '/test/',
    'create_directories'    => TRUE
);

// Check is the folder writable
$result = $file_manager->compress_file($args);

// Output - var dump the result
echo '<div><p>File Creation Result: </p><table><tr><td><b>KEY</b></td><td><b>VALUE</b></td><td><b>TYPE</b></td></tr>';
foreach($result as $key => $value) echo '<tr><td>'.$key.'</td><td>'.var_export($value, TRUE).'</td><td>'.gettype($value).'</td></tr>';
echo '</table></div>';