<?php
/**
 * Name:            Stag File Manager (StagPHP Library)
 * Description:     Contains several global defined variable
 *
 * @package:        StagPHP Library File
 */

require_once 'functions.php';

/** 
 * Stag file manager 
 * 
 * This class must be initialized without
 * any parameters and inside the StagPHP
 * framework */
class stag_file_manager extends stag_file_manager_functions {
    // rename_directory
    // delete_directory

    /** */
    function get_info($absolute_path, $detailed_info = false){
        $detailed_info = $detailed_info ? TRUE : FALSE;

        return parent::get_file_info(ABSPATH.$absolute_path, $detailed_info);
    }

    function scan_directory($absolute_path){
        return parent::scan_directory(ABSPATH.$absolute_path);
    }

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
    function update_file($absolute_path, $content){
        /** Create absolute file path */
        $absolute_path = ABSPATH.$absolute_path;

        /** Check absolute file path and get the response */
        $response = parent::get_file_info($absolute_path);

        if(FALSE === $response['status']){
            $path_components = explode('/', $absolute_path);

            $file_name = $path_components[count($path_components) - 1];
    
            if(empty($file_name)) return [
                'status' => false,
                'description' => 'Filename is empty!'
            ];

            $new_directory_path = substr($absolute_path, 0, strpos($absolute_path, $file_name));

            if(!file_exists($new_directory_path)) if(!parent::create_directory($new_directory_path)) return [
                'status' => false,
                'description' => 'Directory cannot be created!'
            ];
        }

        else if('directory' == $response['type']) return [
            'status' => false,
            'description' => 'Not a valid filename!'
        ];

        parent::save_file($absolute_path, $content);

        /** File updated successfully => return true */
        return [
            'status' => true,
            'description' => 'File "'.$absolute_path.'" has been updated!'
        ];
    }

    function copy_file($absolute_src_path, $absolute_dest_path){
        /** Create absolute file path */
        $absolute_src_path = ABSPATH.$absolute_src_path;

        /** Check absolute file path and get the response */
        $response = parent::get_file_info($absolute_src_path);

        if(FALSE === $response['status']) return [
            'status' => false,
            'description' => 'Source file not found!'
        ];

        else if('directory' == $response['type']) return [
            'status' => false,
            'description' => 'Source is not a file!'
        ];

        $absolute_dest_path = ABSPATH.$absolute_dest_path;

        /** Check absolute file path and get the response */
        $response = parent::get_file_info($absolute_dest_path);

        /**  */
        if(FALSE === $response['status']){
            $path_components = explode('/', $absolute_dest_path);

            $file_name = $path_components[count($path_components) - 1];
    
            if(empty($file_name)) return [
                'status' => false,
                'description' => 'Destination is not a file!'
            ];

            $absolute_dest_dir = substr($absolute_dest_path, 0, strpos($absolute_dest_path, $file_name));

            if(!file_exists($absolute_dest_dir)) {
                $dest_dir_created = parent::create_directory($absolute_dest_dir);
            
                if(FALSE === $dest_dir_created['status']) return [
                    'status' => false,
                    'description' => 'Directory for destination file cannot be created!'
                ];
            }
        }

        else if('directory' == $response['type']) return [
            'status' => false,
            'description' => 'Destination is not a file!'
        ];

        if(copy($absolute_src_path, $absolute_dest_path)) return [
            'status' => true,
            'description' => 'File successfully copied to loc: "'.$absolute_dest_path
        ];
          
          
        else return [
            'status' => false,
            'description' => 'Failed to copy file!'
        ];
    }

    function move_file($absolute_src_path, $absolute_dest_path){
        $copy = $this->copy_file($absolute_src_path, $absolute_dest_path);

        if($copy['status']){
            $delete = parent::delete_file(ABSPATH.$absolute_src_path);

            if($delete) return [
                'status' => TRUE,
                'description' => 'File moved to destination: '.$absolute_dest_path
            ];
            
            else return [
                'status' => FALSE,
                'description' => 'File copied to "'.$absolute_dest_path.'". But failed to delete the source file!'
            ];
        }

        return [
            'status' => FALSE,
            'description' => 'Failed to move file!'
        ];
    }

    function delete_file($absolute_path){
        if(parent::delete_file(ABSPATH.$absolute_path)) return [
            'status' => TRUE,
            'description' => 'File deleted!'
        ];

        return [
            'status' => FALSE,
            'description' => 'File is not valid!'
        ];
    }

    function create_directory($absolute_path){
        if(parent::create_directory(ABSPATH.$absolute_path)) return [
            'status' => TRUE,
            'description' => 'Directory created!'
        ];

        return [
            'status' => FALSE,
            'description' => 'Failed to create directory!'
        ];
    }

    function copy_directory($absolute_src_path, $absolute_dest_path){
        if(parent::copy_directory(ABSPATH.$absolute_src_path, ABSPATH.$absolute_dest_path)) return [
            'status' => TRUE,
            'description' => 'Directory copied!'
        ];

        return [
            'status' => FALSE,
            'description' => 'Failed to copy directory!'
        ];
    }

    function move_directory(){
        
    }
}