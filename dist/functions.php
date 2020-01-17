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
    /** Quick Scan -> stores total file count */
    private $file_count;

    /** Quick Scan -> stores total directory count */
    private $directory_count;

    /** Deep scan root directory */
    private $deep_scan_root;

    /** Create the path */
    protected function create_path($relative_path, $file){
        /** Remove unnecessary slashes from path 
         * and add slash at the beginning */
        $relative_path = preg_replace('#/+#', '/', '/'.$relative_path);

        /** Create absolute path */
        $absolute_path = ABSPATH.$relative_path;

        if(TRUE === $file) return $absolute_path;

        /** Remove extra forward slash from right */
        $relative_path = rtrim($relative_path.'/', '/');

        return $absolute_path.'/';
    }

    /** Get information related to the path */
    protected function get_info($relative_path){
        /** Create absolute path */
        $absolute_path = $this->create_path($relative_path, TRUE);

        /** Is Writeable Flag */
        $is_writeable = FALSE;

        /** Clears the file status cache */
        clearstatcache();

        /** Checks whether the absolute path exists */
        if(file_exists($absolute_path)){
            /** Check if the file or directory writable */
            if(is_writable($absolute_path)) $is_writeable = TRUE;

            /** Checks whether the absolute path belongs to
             * a file or a directory */
            if(is_file($absolute_path)) {
                return [
                    'status'        => TRUE,
                    'type'          => 'file',
                    'absolute_path' => $absolute_path ,
                    'is_writeable'  => $is_writeable
                ];
            }
            
            else return [
                'status'        => TRUE,
                'type'          => 'directory',
                'absolute_path' => $absolute_path.'/',
                'is_writeable'  => $is_writeable
            ];
        }

        /** Return false if does not exists */
        return [
            'status'        => FALSE,
            'type'          => 'NA',
            'absolute_path' => $absolute_path,
            'description'   => 'Directory or file does not exits!'
        ];
    }

    /** Get file properties */
    protected function file_properties($absolute_path){
        /** Clears the file status cache */
        clearstatcache();
    
        /** Get file mime type */
        $file_type = mime_content_type($absolute_path);

        /** get file size */
        $file_size = filesize($absolute_path);

        /** Get file permission */
        $file_permission = substr(sprintf('%o', fileperms($absolute_path)), -4);

        /** Last modified */
        $file_modified_time = date("Y-m-d H:i:s", filemtime($absolute_path));

        /** Return file property */
        return [
            'status'            => TRUE,
            'type'              => $file_type,
            'size'              => $file_size,
            'permission'        => $file_permission,
            'modified_time'     => $file_modified_time
        ];
    }

    /** Helper Function: Quickly scan directory */
    protected function quick_scan($absolute_path){
        $size = 0;

        foreach (glob(rtrim($absolute_path, '/').'/*', GLOB_NOSORT) as $each) {
            if(is_file($each)){
                $size += filesize($each);
                $this->file_count++;
            } else {
                $size += $this->quick_scan($each);
                $this->file_count++;
            }
        }

        return $size;
    }

    /** Get directory properties */
    protected function directory_properties($absolute_path){
        /** Clears the file status cache */
        clearstatcache();
    
        /** Get file permission */
        $directory_permission = substr(sprintf('%o', fileperms($absolute_path)), -4);

        /** Reset directory count */
        $this->directory_count = 0;

        /** Reset file count */
        $this->file_count = 0;

        /** Quick scan directory 
         * returns: directory size
         * Sets: directory and file count */
        $directory_size = $this->quick_scan($absolute_path);

        /** Last modified */
        $directory_modified_time = date("Y-m-d H:i:s", filemtime($absolute_path.'.'));

        /** Return file property */
        return [
            'status'            => TRUE,
            'size'              => $directory_size,
            'directory_count'   => $this->directory_count,
            'file_count'        => $this->file_count,
            'permission'        => $directory_permission,
            'modified_time'     => $directory_modified_time
        ];
    }

    /** Single level directory scan */
    protected function directory_scan($absolute_path){
        /** Defining blank array */
        $directories = $files = array();

        /** Default PHP function to scan directory */
        $response = scandir($absolute_path);
    
        /** Loop response and create separate arrays for directory and files */
        foreach($response as $key => $value) if(!in_array($value, array(".",".."))){
            /** Create array of directories */
            if(is_dir($absolute_path.$value)) array_push($directories, $value);

            // Create array of files
            else array_push($files, $value);
        }
        
        /** Return the list */
        return array(
            'status'      => TRUE,
            'directories' => $directories,
            'files'       => $files
        );
    }

    /** Helper Function: Recursive directory scan */
    protected function recursive_directory_scan($absolute_path){
        /** Directories to store nested directory */
        $directories = array();

        /** Directories to store file structure */
        $files = array();

        /** Default PHP function to scan directory */
        $items_array = scandir($absolute_path);
        
        /** Loop entities */
        foreach($items_array as $item) if(!in_array($item, array(".",".."))){
            /** Create relative path */
            $relative_path = str_replace($this->deep_scan_root, '/', $absolute_path.$item);

            /** Check is directory */
            if(is_dir($absolute_path.$item)){
                $temp_array = array(
                    'type'          => 'folder',
                    'name'          => $item,
                    'relative_path' => $relative_path.'/',
                    'sub_directory' => $this->recursive_directory_scan($absolute_path.$item.'/')
                );
    
                array_push($directories, $temp_array);
            } else {
                $file_array = array(
                    'type'          => 'file',
                    'name'          => $item,
                    'relative_path' => $relative_path,
                );
    
                array_push($files, $file_array);
            }
        }

        /** Return directory structure */
        return array_merge($directories, $files);
    }

    /** Deep scan directory for all the files and folder */
    protected function deep_directory_scan($absolute_path){
        /** Clears the file status cache */
        clearstatcache();

        /** Set deep scan root */
        $this->deep_scan_root = $absolute_path;

        /** Recursively scan directory */
        return array(
            'status'            => TRUE,
            'directory_items'   => $this->recursive_directory_scan($absolute_path)
        );
    }

    /** Create nested directory */
    protected function create_empty_directory($absolute_path){
        /** Attempts to create the nested directories
         * specified by the absolute_path */
        if(TRUE === @mkdir($absolute_path, 0777, TRUE)) return TRUE;

        /** Return FALSE on failure */
        return FALSE;
    }

    /** Create nested directory */
    protected function create_directory_for_file($absolute_path){
        /** Get path component array */
        $path_components = explode('/', $absolute_path);

        /** Get filename */
        $file_name = $path_components[count($path_components) - 1];

        /** Return false if filename is empty */
        if(empty($file_name)) return FALSE;

        /** Get absolute directory path without filename */
        $absolute_directory_path = str_replace($file_name, '', $absolute_path);

        /** Return true if directory already exists */
        if(file_exists($absolute_directory_path)) return TRUE;

        /** Create directory or nested directories
         * for the file, if does not exists */
        if(TRUE == @mkdir($absolute_directory_path, 0777, TRUE)) return TRUE;

        /** Return FALSE on failure */
        return FALSE;
    }

    /** Create file */
    protected function save_file($absolute_path, $content){
        /** creates a file if does not exists  */
        $result = @file_put_contents($absolute_path, $content, LOCK_EX);

        /** Return FALSE on failure */
        if(FALSE == $result) return FALSE;

        /** Return TRUE on success */
        return TRUE;
    }

    /** Delete File */
    protected function delete_file($absolute_path){
        if(TRUE === @unlink($absolute_path)) return TRUE;

        return FALSE;
    }

    protected function recursive_copy($src_path, $dst_path){  
        // open the source directory 
        $dir = opendir($src_path);  
      
        // Make the destination directory if not exist 
        @mkdir($dst_path, 0777, TRUE);
      
        // Loop through the files in source directory 
        while(false !== ($file = readdir($dir))){
            if(($file != '.') && ($file != '..')){  
                if(is_dir($src_path.$file))
                $this->recursive_copy($src_path.$file.'/', $dst_path.$file.'/');  
      
                else copy($src_path.$file, $dst_path.$file);
            }  
        }
      
        // Close directory
        closedir($dir); 
    }

    protected function recursive_move($src_path, $dst_path){
        // open the source directory 
        $dir = opendir($src_path);

        // Make the destination directory if not exist 
        @mkdir($dst_path, 0777, TRUE);
      
        // Loop through the files in source directory 
        while(false !== ($file = readdir($dir))){
            if(($file != '.') && ($file != '..')){  
                if(is_dir($src_path.$file))
                $this->recursive_move($src_path.$file.'/', $dst_path.$file.'/');  
      
                else {
                    copy($src_path.$file, $dst_path.$file);

                    /** Unlink file */
                    unlink($src_path.$file);
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
      
        // Loop through the files in source directory 
        while(false !== ($file = readdir($dir))){
            if(($file != '.') && ($file != '..')){
                /** Delete directory */
                if(is_dir($absolute_path.$file))
                $this->recursive_delete($absolute_path.$file.'/');
      
                /** Unlink file */
                else unlink($absolute_path.$file);
            }
        }

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

    protected function move_directory($src_path, $dst_path){
        $source = $this->get_file_info($src_path);

        if($source['status'] && 'directory' == $source['type']){
            $destination = $this->get_file_info($dst_path);

            if($destination['status'] && 'file' == $destination['type']) return FALSE;

            $this->recursive_move($src_path, $dst_path);

            return TRUE;
        }

        return FALSE;
    }

    protected function delete_directory($absolute_path){
        $absolute_path_info = $this->get_file_info($absolute_path);

        if($absolute_path_info['status'] && 'directory' == $absolute_path_info['type']){
            $this->recursive_delete($absolute_path);

            return TRUE;
        }

        return FALSE;
    }

    protected function download_file($remote_url, $absolute_path){
        /** Download file flag */
        $download_file = FALSE;

        /** Check for provided absolute path */
        if(!empty($absolute_path)){
            $file = @fopen($absolute_path, "w");

            if(FALSE === $file) return FALSE;

            $download_file = TRUE;
        }

        // Get The Zip File From Server
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $remote_url);
        curl_setopt($curl, CURLOPT_FAILONERROR, true);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl, CURLOPT_AUTOREFERER, true);
        curl_setopt($curl, CURLOPT_BINARYTRANSFER,true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_TIMEOUT, 10);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0); 
        if($download_file) curl_setopt($curl, CURLOPT_FILE, $file);
        $result = curl_exec($curl);
        curl_close($curl);

        if(FALSE === $result) return FALSE;
        else {
            if($download_file) return TRUE;
            else return $result;
        }
    }

    protected function extract_zip_file($zip_loc, $extract_loc){
        $zip_loc_info = $this->get_file_info($zip_loc);

        if($zip_loc_info['status'] && 'file' == $zip_loc_info['type']){
            /** Zip Archive Class */
            $zip = new ZipArchive;

            /** Open zip file */
            $zip_content = $zip->open($zip_loc);

            /** Get the absolute path to zip file
             * in order to extract it o same directory */
            if(empty($extract_loc)) $extract_loc = pathinfo(realpath($zip_loc), PATHINFO_DIRNAME);

            /** Returns TRUE on success */
            if(TRUE === $zip_content){
                $zip_content->extractTo($extract_loc);
                $zip_content->close();
                return TRUE;
            }
        }
    
        return FALSE;
    }

    protected function create_zip($zip_location){
        $zip = new ZipArchive;
        if($zip->open($zip_location, ZipArchive::OVERWRITE) === TRUE){
            foreach($absolute_files as $absolute_file){
                $zip->addFile($absolute_file, $absolute_file);
            }
        
            // All files are added, so close the zip file.
            $zip->close();
        }
    }
}