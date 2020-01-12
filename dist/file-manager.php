<?php
/**
 * Name:            Stag File Manager (StagPHP Library)
 * Description:     Contains several global defined variable
 *
 * @package:        StagPHP Library File
 */

require_once 'file-manager.php';

/** 
 * Stag file manager 
 * 
 * This class must be initialized without
 * any parameters and inside the StagPHP
 * framework */
class stag_file_manager extends stag_file_manager_functions {
    // get_file_info(false)
    // get_directory_info
    // scan_directory
    // update_file
    // copy_file
    // copy_directory
    // move_file
    // move_directory
    // rename_file
    // rename_directory
    // delete_file
    // delete_directory

    /** 
     * Get file info
     * 
     * Return file or directory detailed information
     * 
     * @param
     *      -> absolute_path: of the file or directory which needed to be checked
     *      -> detailed_info: flag to retrieve detailed info
     * 
     * @return
     *      -> file_info: detailed file or directory information
     *      -> false: incase file don't exists */
    function update_file($absolute_file_path, $content){

    }
}