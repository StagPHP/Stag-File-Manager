<?php
/**
 * Simple Example to create a file
 */

// Create new file manger instance
$file_manager = new stag_file_manager;

// Remote URL from where file needed to be fetched
$remote_url = 'https://stagphp.github.io/stag-file-manager/README.md';

// Check is the folder writable
$result = $file_manager->get_remote_file_content($remote_url);

// Output - var dump the result
echo '<div><p>File Download Result: </p><table><tr><td><b>KEY</b></td><td><b>VALUE</b></td><td><b>TYPE</b></td></tr>';
foreach($result as $key => $value) echo '<tr><td>'.$key.'</td><td>'.var_export($value, TRUE).'</td><td>'.gettype($value).'</td></tr>';
echo '</table></div>';