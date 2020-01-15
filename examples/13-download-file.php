<?php
/**
 * Simple Example to create a file
 */

// Create new file manger instance
$file_manager = new stag_file_manager;

// Remote URL from where file needed to be fetched
$remote_url = 'https://stagphp.github.io/stag-file-manager/README.md';

// Specified location to save downloaded file
$save_location = '/test/downloaded-readme.md';

// Check is the folder writable
$result = $file_manager->download_file($remote_url, $save_location);

// Output - var dump the result
echo '<div><p>File Download Result: </p><table><tr><td><b>KEY</b></td><td><b>VALUE</b></td><td><b>TYPE</b></td></tr>';
foreach($result as $key => $value) echo '<tr><td>'.$key.'</td><td>'.var_export($value, TRUE).'</td><td>'.gettype($value).'</td></tr>';
echo '</table></div>';