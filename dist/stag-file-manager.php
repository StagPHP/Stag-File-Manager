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
     * Description: Return basic information related 
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

    function directory_scan($relative_path){
        /** get file info for processing */
        $directory_info = parent::get_info($relative_path);

        /** Get file properties for a valid file type */
        if(TRUE === $directory_info['status'] && 'directory' == $directory_info['type'])
        return parent::directory_scan($directory_info['absolute_path']);

        /** Return false if directory does not exists */
        return [
            'status'      => FALSE,
            'description' => '"'.$absolute_path.'" is not a directory!'
        ];
    }

    function deep_directory_scan($relative_path){
        /** get file info for processing */
        $directory_info = parent::get_info($relative_path);

        /** Get file properties for a valid file type */
        if(TRUE === $directory_info['status'] && 'directory' == $directory_info['type'])
        return parent::deep_directory_scan($directory_info['absolute_path']);

        /** Return false if directory does not exists */
        return [
            'status'      => FALSE,
            'description' => '"'.$absolute_path.'" is not a directory!'
        ];
    }

    /** Get file info
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
    function update_file($relative_path, $content){
        /** action */
        $action = 'updated';

        /** Get file info for processing */
        $file_info = parent::get_info($relative_path);

        /** File does not exists */
        if(FALSE === $file_info['status']){
            /** Create path for the new file */
            $file_path = parent::create_path($relative_path, TRUE);

            /** Create directory to save file, and
             * set action to updated */
            if(parent::create_directory_for_file($file_path)) {
                $absolute_file_path = $file_path;
                $action = 'created';
            }

            else return [
                'status' => false,
                'description' => 'Specified file path is not valid!'
            ];
        }

        /** Return false: If relative file specified
         * contains the path of a directory
         * instead of the file */
        else if('directory' == $file_info['type']) return [
            'status' => false,
            'description' => 'Specified file path is not valid!'
        ];

        else $absolute_file_path = $file_info['absolute_path'];

        /** Finally save file */
        parent::save_file($absolute_file_path, $content);

        /** File updated successfully */
        return [
            'status' => true,
            'absolute_path' => $absolute_file_path,
            'description' => 'File has been '.$action.'!'
        ];
    }

    function copy_file($relative_src_path, $relative_dest_path){
        /** action */
        $action = 'copied and overwritten';

        /** Get source path info for processing */
        $src_file_info = parent::get_info($relative_src_path);

        if(FALSE === $src_file_info['status']) return [
            'status' => false,
            'description' => 'Source file not found!'
        ];

        else if('directory' == $src_file_info['type']) return [
            'status' => false,
            'description' => 'Source is not a file!'
        ];

        $absolute_src_file_path = $src_file_info['absolute_path'];

        /** Get destination path info for processing */
        $dest_file_info = parent::get_info($relative_dest_path);

        /** File does not exists */
        if(FALSE === $dest_file_info['status']){
            /** Create path for the new file */
            $file_path = parent::create_path($relative_dest_path, TRUE);

            /** Create directory to save file, and
             * set action to updated */
            if(parent::create_directory_for_file($file_path)) {
                $absolute_dest_file_path = $file_path;
                $action = 'copied';
            }

            else return [
                'status' => false,
                'description' => 'Specified file path is not valid!'
            ];
        }

        /** Return false: If relative file specified
         * contains the path of a directory
         * instead of the file */
        else if('directory' == $dest_file_info['type']) return [
            'status' => false,
            'description' => 'Specified file path is not valid!'
        ];

        else $absolute_dest_file_path = $dest_file_info['absolute_path'];

        if(copy($absolute_src_file_path, $absolute_dest_file_path)) return [
            'status'            => true,
            'source_file_path'  => $absolute_src_file_path,
            'file_path'         => $absolute_dest_file_path,
            'description'       => 'File successfully '.$action.'!'
        ];
          
        else return [
            'status' => false,
            'description' => 'Failed to copy file!'
        ];
    }

    function move_file($relative_src_path, $relative_dest_path){
        /** action */
        $action = 'moved and overwritten';

        /** Get source path info for processing */
        $src_file_info = parent::get_info($relative_src_path);

        if(FALSE === $src_file_info['status']) return [
            'status' => false,
            'description' => 'Source file not found!'
        ];

        else if('directory' == $src_file_info['type']) return [
            'status' => false,
            'description' => 'Source is not a file!'
        ];

        $absolute_src_file_path = $src_file_info['absolute_path'];

        /** Get destination path info for processing */
        $dest_file_info = parent::get_info($relative_dest_path);

        /** File does not exists */
        if(FALSE === $dest_file_info['status']){
            /** Create path for the new file */
            $file_path = parent::create_path($relative_dest_path, TRUE);

            /** Create directory to save file, and
             * set action to updated */
            if(parent::create_directory_for_file($file_path)) {
                $absolute_dest_file_path = $file_path;
                $action = 'moved';
            }

            else return [
                'status' => false,
                'description' => 'Specified file path is not valid!'
            ];
        }

        /** Return false: If relative file specified
         * contains the path of a directory
         * instead of the file */
        else if('directory' == $dest_file_info['type']) return [
            'status' => false,
            'description' => 'Specified file path is not valid!'
        ];

        else $absolute_dest_file_path = $dest_file_info['absolute_path'];

        if(copy($absolute_src_file_path, $absolute_dest_file_path)) {
            $deleted = parent::delete_file($absolute_src_file_path);

            if($deleted) return [
                'status'            => TRUE,
                'file_path'         => $absolute_dest_file_path,
                'description'       => 'File successfully '.$action.'!'
            ];
            
            return [
                'status' => FALSE,
                'description' => 'File moved, but failed to delete the source file!'
            ];
        }
          
        else return [
            'status' => false,
            'description' => 'Failed to move file!'
        ];
    }

    function delete_file($relative_path){
        /** Get source path info for processing */
        $file_info = parent::get_info($relative_path);

        if(FALSE === $file_info['status']) return [
            'status' => false,
            'description' => 'File not found!'
        ];

        else if('directory' == $file_info['type']) return [
            'status' => false,
            'description' => 'Invalid file!'
        ];

        if(parent::delete_file($file_info['absolute_path'])) return [
            'status' => TRUE,
            'description' => 'File deleted!'
        ];

        return [
            'status' => FALSE,
            'description' => 'File is not valid!'
        ];
    }

    function create_directory($relative_path){
        /** Get destination path info for processing */
        $path_info = parent::get_info($relative_path);

        if($path_info['status'] && 'file' == $path_info['type']) return [
            'status' => FALSE,
            'description' => 'Invalid directory name!'
        ];

        else if($path_info['status']) return [
            'status' => TRUE,
            'description' => 'Directory already exists!'
        ];

        if(parent::create_empty_directory($path_info['absolute_path'])) return [
            'status' => TRUE,
            'description' => 'Directory created!'
        ];

        return [
            'status' => FALSE,
            'description' => 'Failed to create directory!'
        ];
    }

    function copy_directory($relative_src_path, $relative_dest_path){
        /** Get source path info for processing */
        $src_dir_info = parent::get_info($relative_src_path);

        if(FALSE === $src_dir_info['status']) return [
            'status' => false,
            'description' => 'Source directory does not exists!'
        ];

        else if('file' == $src_dir_info['type']) return [
            'status' => false,
            'description' => 'Invalid source directory!'
        ];

        $absolute_src_dir_path = $src_dir_info['absolute_path'];

        /** Get destination path info for processing */
        $dest_dir_info = parent::get_info($relative_dest_path);

        if(TRUE === $dest_dir_info['status'] && 'file' == $dest_dir_info['type']) return [
            'status' => false,
            'description' => 'Invalid destination directory!'
        ];

        $absolute_dest_dir_path = $dest_dir_info['absolute_path'];

        /** Recursive copy also creates the directory 
         * if required */
        parent::recursive_copy($absolute_src_dir_path, $absolute_dest_dir_path);

        return [
            'status'            => TRUE,
            'source_dir_path'   => $absolute_src_dir_path,
            'dir_path'          => $absolute_dest_dir_path,
            'description'       => 'Directory copied!'
        ];
    }

    function move_directory($relative_src_path, $relative_dest_path){
        /** Get source path info for processing */
        $src_dir_info = parent::get_info($relative_src_path);

        if(FALSE === $src_dir_info['status']) return [
            'status' => false,
            'description' => 'Source directory does not exists!'
        ];

        else if('file' == $src_dir_info['type']) return [
            'status' => false,
            'description' => 'Invalid source directory!'
        ];

        $absolute_src_dir_path = $src_dir_info['absolute_path'];

        /** Get destination path info for processing */
        $dest_dir_info = parent::get_info($relative_dest_path);

        if(TRUE === $dest_dir_info['status'] && 'file' == $dest_dir_info['type']) return [
            'status' => false,
            'description' => 'Invalid destination directory!'
        ];

        $absolute_dest_dir_path = $dest_dir_info['absolute_path'];

        /** Recursive copy also creates the directory 
         * if required */
        parent::recursive_move($absolute_src_dir_path, $absolute_dest_dir_path);

        return [
            'status'            => TRUE,
            'dir_path'          => $absolute_dest_dir_path,
            'description'       => 'Directory moved!'
        ];
    }

    function delete_directory($relative_path){
        /** Get source path info for processing */
        $path_info = parent::get_info($relative_path);

        if(FALSE === $path_info['status']) return [
            'status' => TRUE,
            'description' => 'Directory already deleted!'
        ];

        else if('file' == $path_info['type']) return [
            'status' => TRUE,
            'description' => 'Invalid directory!'
        ];

        $dir_path = $path_info['absolute_path'];

        /** Recursive copy also creates the directory 
         * if required */
        parent::recursive_delete($dir_path);

        return [
            'status'            => TRUE,
            'description'       => 'Directory deleted!'
        ];
    }

    function download_file($remote_url, $download_location){
        /** Check download location */
        $download_location_info = parent::get_info($download_location);

        $download_location = $download_location_info['absolute_path'];

        /** File does not exists */
        if(FALSE === $download_location_info['status'] && FALSE === parent::create_directory_for_file($download_location)) return [
            'status' => false,
            'description' => 'Directory for download location can not be created!'
        ];

        /** Return false: If relative file specified
         * contains the path of a directory
         * instead of the file */
        else if('directory' == $download_location_info['type']) return [
            'status' => false,
            'description' => 'Specified download file path is not valid!'
        ];

        if(parent::download_file($remote_url, $download_location)) return [
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