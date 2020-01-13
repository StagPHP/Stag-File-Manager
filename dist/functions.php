<?php
/**
 * Name:            Stag File Manager (StagPHP Library)
 * Description:     Contains core functions of the StagPHP
 *                  File Manager Library
 *
 * @package:        StagPHP Library File
 */

/** Stag file manager Base Functions */
class stag_file_manager_functions{
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
    protected function get_file_info($absolute_path, $detailed_info = FALSE){
        $is_writeable = FALSE;

        /** 
         * Checks whether the absolute file belongs to
         * a file or a directory exists or not */
        if(file_exists($absolute_path)){
            /** Check if the file or directory writable */
            if(is_writable($absolute_path)) $is_writeable = TRUE;

            /** 
             * Check whether it is a file or a directory
             * 
             * Check for file */
            if(is_file($absolute_path)) {
                /** Return detailed info */
                if($detailed_info){
                    /** Clears the file status cache */
                    clearstatcache();
    
                    /** Get file permission */
                    $file_permission = substr(sprintf('%o', fileperms($absolute_path)), -4);

                    /** Get file mime type */
                    $file_type = mime_content_type($absolute_path);

                    /** Last modified */
                    $file_mod = date("Y-m-d H:i:s", filemtime($absolute_path));

                    /** Return detailed info */
                    return [
                        'status'            => TRUE,
                        'type'              => 'file',
                        'is_writeable'      => $is_writeable,
                        'file_permission'   => $file_permission,
                        'last_modified_time'=> $file_mod
                    ];
                }
                
                /** Return minimal info */
                else return [
                    'status'      => TRUE,
                    'type'        => 'file',
                    'is_writeable'=> $is_writeable
                ];
            }
            
            /** Check for directory */
            else {
                /** Return detailed info */
                if($detailed_info){
                    /** Clears the file status cache */
                    clearstatcache();
    
                    /** Get file permission */
                    $file_permission = substr(sprintf('%o', fileperms($absolute_path)), -4);

                    /** Last modified */
                    $file_mod = date("Y-m-d H:i:s", filemtime($filename.'.'));

                    /** Return detailed info */
                    return [
                        'status'                => TRUE,
                        'type'                  => 'file',
                        'is_writeable'          => $is_writeable,
                        'directory_permission'  => $file_permission,
                        'last_modified_time'    => $file_mod
                    ];
                }

                return [
                    'status'      => TRUE,
                    'type'        => 'directory',
                    'is_writeable'=> $is_writeable
                ];
            }
        }
        
        /** Return false if does not exists */
        return [
            'status'      => FALSE,
            'description' => 'Directory or file does not exits'
        ];
    }

    /** 
     * Scan directory
     * 
     * Return the list of files or directories
     * 
     * @param
     *      -> absolute_path: of the directory which needed to be scanned
     * 
     * @return
     *      -> boolean: true and false (incase directory don't exists)
     *      -> list: array of directories and files */
    protected function scan_directory($absolute_path){
        /** Defining blank array */
        $directories = $files = array();

        /** Check absolute path is directory or not */
        if(is_dir($absolute_path)){
            /** Default PHP function to scan directory */
            $response = scandir($absolute_path);
        
            /** Loop response and create separate arrays for directory and files */
            foreach($response as $key => $value){
                if(!in_array($value, array(".",".."))){
                    /** Create array of directories */
                    if(is_dir($absolute_path.DIRECTORY_SEPARATOR.$value)) array_push($directories, $value);

                    // Create array of files
                    else array_push($files, $value);
                }
            }
            
            /** Return the list */
            return array(
                'status'      => TRUE,
                'directories' => $directories,
                'files'       => $files
            );
        }

        /** Return false if directory does not exists */
        return [
            'status'      => FALSE,
            'description' => '"'.$absolute_path.'" is not a directory!'
        ];
    }

    /** 
     * Create nested directory
     * 
     * @param
     *      -> absolute_path: of the directory which needed to be created
     * 
     * @return
     *      -> boolean: true (directory created) or false */
    protected function create_directory($absolute_path){
        $result = $this->get_file_info($absolute_path);

        if($result['status']) FALSE;

        /** 
         * Attempts to create the nested directories
         * specified by the absolute_path */
        if(@mkdir($absolute_path, 0777, true)) return TRUE;

        /** Return FALSE on failure */
        return FALSE;
    }

    /** 
     * Save the file
     * 
     * If file does not exists, it creates and save the content
     * otherwise it replace the old file content with new content
     * 
     * @param
     *      -> absolute_path: of the file which needed to be saved
     *      -> content: content of the file
     * 
     * @return
     *      -> boolean: true (directory created) or false */
    protected function save_file($absolute_path, $content){
        /** creates a file if does not exists  */
        $result = file_put_contents($absolute_path, $content, LOCK_EX);

        /** Return FALSE on failure */
        if(FALSE == $result) return FALSE;

        /** Return TRUE on success */
        return TRUE;
    }

    /** Delete File */
    protected function delete_file($absolute_path){
        $result = $this->get_file_info($absolute_path);

        if($result['status'] && $result['is_writeable'] && 'file' == $result['type']) if(unlink($absolute_path)) return TRUE;

        return FALSE;
    }

    protected function recursive_copy($src_path, $dst_path){  
        // open the source directory 
        $dir = opendir($src_path);  
      
        // Make the destination directory if not exist 
        @mkdir($dst_path, 0777);
      
        // Loop through the files in source directory 
        while(false !== ($file = readdir($dir))){
            if(($file != '.') && ($file != '..')){  
                if(is_dir($src_path.DIRECTORY_SEPARATOR.$file))
                $this->recursive_copy($src_path.DIRECTORY_SEPARATOR.$file, $dst_path.DIRECTORY_SEPARATOR.$file);  
      
                else copy($src_path.DIRECTORY_SEPARATOR.$file, $dst_path.DIRECTORY_SEPARATOR.$file);
            }  
        }
      
        // Close directory
        closedir($dir); 
    }

    protected function recursive_move($src_path, $dst_path){
        // open the source directory 
        $dir = opendir($src_path);

        // Make the destination directory if not exist 
        @mkdir($dst_path, 0777);
      
        // Loop through the files in source directory 
        while(false !== ($file = readdir($dir))){
            if(($file != '.') && ($file != '..')){  
                if(is_dir($src_path.DIRECTORY_SEPARATOR.$file))
                $this->recursive_copy($src_path.DIRECTORY_SEPARATOR.$file, $dst_path.DIRECTORY_SEPARATOR.$file);  
      
                else {
                    copy($src_path.DIRECTORY_SEPARATOR.$file, $dst_path.DIRECTORY_SEPARATOR.$file);

                    /** Unlink file */
                    unlink($src_path.DIRECTORY_SEPARATOR.$file);
                }
            }  
        }
      
        // Close directory
        closedir($dir);

        // Remove this directory
        rmdir($src_path);
    }

    protected function recursive_delete($absolute_path){
        /** Open the source directory */
        $dir = opendir($absolute_path);

        // count loop 
        $loop = 0;
      
        // Loop through the files in source directory 
        while(false !== ($file = readdir($dir))){
            if(($file != '.') && ($file != '..')){
                /** Delete directory */
                if(is_dir($absolute_path.DIRECTORY_SEPARATOR.$file))
                $this->recursive_delete($absolute_path.DIRECTORY_SEPARATOR.$file);
      
                /** Unlink file */
                else unlink($absolute_path.DIRECTORY_SEPARATOR.$file);
            }

            // increment the loop
            $loop++;
        }

        // if(3 > $loop) {
        //     // Remove this directory
        //     rmdir($absolute_path);
        // }

        // Close directory
        closedir($dir);

        // Remove this directory
        rmdir($absolute_path);
    }

    protected function copy_directory($src_path, $dst_path){
        $source = $this->get_file_info($src_path);

        if($source['status'] && 'directory' == $source['type']){
            $destination = $this->get_file_info($dst_path);

            if($destination['status'] && 'file' == $destination['type']) return FALSE;

            $this->recursive_copy($src_path, $dst_path);

            return TRUE;
        }

        return FALSE;
    }
}