<?php
/**
 * Simple Example to create a file
 */

// Create new file manger instance
$file_manager = new stag_file_manager;

// Dynamic File  Name
// $new_filename = 'file-'.(string)round(microtime(true) * 1000).'.txt';
$new_filename = 'new-file.txt';

$file_content = 'This is new file, created on '.date("Y-m-d H:i:s").' UTC';

// Check is the folder writable
$result = $file_manager->update_file('/examples/new-files/'.$new_filename, $file_content);

// Output - var dump the result
echo '<div><p>File Creation Result: </p><table><tr><td><b>KEY</b></td><td><b>VALUE</b></td><td><b>TYPE</b></td></tr>';
foreach($result as $key => $value) echo '<tr><td>'.$key.'</td><td>'.var_export($value, TRUE).'</td><td>'.gettype($value).'</td></tr>';
echo '</table></div>';