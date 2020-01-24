<?php
/**
 * Simple Example to create a file
 */

// Create new file manger instance
$file_manager = new stag_file_manager('/examples');

// Remote URL from where file needed to be fetched
$remote_url = 'https://stagphp.github.io/stag-file-manager/README.md';

// Check is the folder writable
$result = $file_manager->download_file(array(
    'remote_url'            => $remote_url,             // Directory location where file will be created
    'directory'             => '/test/',                // File content
    'file_name'             => 'downloaded-readme.md',  // Name of the file
    // 'create_directories'    => FALSE,                // By default create directory flag assumed false
    // 'overwrite_file'        => FALSE                 // By default create directory flag assumed false
));

// Output - var dump the result
echo '<div><p>File Download Result: </p><table><tr><td><b>KEY</b></td><td><b>VALUE</b></td><td><b>TYPE</b></td></tr>';
foreach($result as $key => $value) echo '<tr><td>'.$key.'</td><td>'.var_export($value, TRUE).'</td><td>'.gettype($value).'</td></tr>';
echo '</table></div>';