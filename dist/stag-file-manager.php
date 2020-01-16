<?php
/**
 * Name:            Stag File Manager (StagPHP Library)
 * Description:     Contains several global defined variable
 *
 * @package:        StagPHP Library File
 */

require_once 'functions.php';

/** Stag file manager 
 * 
 * This class must be initialized without
 * any parameters and inside the StagPHP
 * framework */
class stag_file_manager extends stag_file_manager_functions {
    /** Get file info
     * 
     * Description: Return baisc information related 
     * to file or directory
     * 
     * @param string $absolute_path
     * Description: absolute path of the file or 
     * directory which needed to be checked
     * 
     * @return array
     * Check documentation for more information */
    function get_info($relative_path){
        return parent::get_info($relative_path);
    }

    function get_file_properties($relative_path){
        /** get file info for processing */
        $file_info = parent::get_info($relative_path);

        /** Get file properties for a valid file type */
        if(TRUE === $file_info['status'] && 'file' == $file_info['type'])
        return parent::file_properties($file_info['absolute_path']);

        /** Return error for invalid file type */
        return array(
            'status'      => FALSE,
            'description' => 'File does not exists!'
        );
    }

    function get_directory_properties($relative_path){
        /** get file info for processing */
        $directory_info = parent::get_info($relative_path);

        /** Get file properties for a valid file type */
        if(TRUE === $directory_info['status'] && 'directory' == $directory_info['type'])
        return parent::directory_properties($directory_info['absolute_path']);

        /** Return error for invalid file type */
        return array(
            'status'      => FALSE,
            'description' => 'Directory does not exists!'
        );
    }

    function scan_directory($relative_path){
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

        $action = 'updated';

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

            $action = 'created';
        }

        else if('directory' == $response['type']) return [
            'status' => false,
            'description' => 'Not a valid filename!'
        ];

        parent::save_file($absolute_path, $content);

        /** File updated successfully => return true */
        return [
            'status' => true,
            'absolute_path' => $absolute_path,
            'description' => 'File has been '.$action.'!'
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

    function move_directory($absolute_src_path, $absolute_dest_path){
        if(parent::move_directory(ABSPATH.$absolute_src_path, ABSPATH.$absolute_dest_path)) return [
            'status' => TRUE,
            'description' => 'Directory copied!'
        ];

        return [
            'status' => FALSE,
            'description' => 'Failed to copy directory!'
        ];
    }

    function delete_directory($absolute_path){
        if(parent::delete_directory(ABSPATH.$absolute_path)) return [
            'status' => TRUE,
            'description' => 'Directory deleted!'
        ];

        return [
            'status' => FALSE,
            'description' => 'Failed to delete directory!'
        ];
    }

    function download_file($remote_url, $absolute_path){
        $absolute_path = ABSPATH.$absolute_path;

        /** Check absolute file path and get the response */
        $absolute_path_info = parent::get_file_info($absolute_path);

        /**  */
        if(FALSE === $absolute_path_info['status']){
            $path_components = explode('/', $absolute_path);

            $file_name = $path_components[count($path_components) - 1];
    
            if(empty($file_name)) return [
                'status' => false,
                'description' => 'Destination is not a file!'
            ];

            $absolute_dest_dir = substr($absolute_path, 0, strpos($absolute_path, $file_name));

            if(!file_exists($absolute_dest_dir)) {
                $dest_dir_created = parent::create_directory($absolute_dest_dir);
            
                if(FALSE === $dest_dir_created['status']) return [
                    'status' => false,
                    'description' => 'Directory for destination file cannot be created!'
                ];
            }
        }

        else if('directory' == $absolute_path_info['type']) return [
            'status' => false,
            'description' => 'Destination is not a file!'
        ];


        if(parent::download_file($remote_url, $absolute_path)) return [
            'status' => TRUE,
            'description' => 'File Downloaded!'
        ];

        return [
            'status' => FALSE,
            'description' => 'Failed to Download File!'
        ];
    }

    function get_remote_file_content($remote_url){
        $content = parent::download_file($remote_url, NULL);

        if(FALSE !== $content) return [
            'status' => TRUE,
            'content' => $content,
            'description' => 'Remote File Content Fetched!'
        ];

        return [
            'status' => FALSE,
            'description' => 'Failed to Fetch Remote File Content!'
        ];
    }
}