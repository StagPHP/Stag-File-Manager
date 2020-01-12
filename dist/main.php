<?php
/**
 * Name:            CLI Commands (StagPHP Library)
 * Description:     Contains several global defined variable
 *
 * @package:        StagPHP Library File
 */

/** Stag file operation */
class stag_file_operator{
  /** Initialized Flag */
  private $initialized = false;

  /** Flag to check errors on recursive operation */
  private $rec_errors = array();

  /** Variable to store directory tree */
  private $dir_tree;

  /** Check flag and initialize */
  function __construct(){
    if('APP_STARTED') $this->initialized = true;
  }

  /** Check function is safe to execute */
  private function safe_to_execute(){
    if(!$this->initialized) return [
      'status' => false,
      'description' => 'Can not access controller outside of the application!'
    ];
  }

  /** Check path to a file or a directory */
  private function check_path($absolute_path, $file_type = null){
    /** Checks whether a file or a directory
     * exits */
    if(file_exists($absolute_path)){
      /** check whether it is a file or a directory */
      if(is_file($absolute_path)){
        return [
          'status'      => TRUE,
          'type'        => 'file',
          'description' => 'Files exists'
        ];
      } else {
        return [
          'status'      => TRUE,
          'type'        => 'directory',
          'description' => 'Directory exists'
        ];
      }
    } else {
      return [
        'status'      => FALSE,
        'description' => 'File or directory do not exists!'
      ];
    }
  }

  private function create_directory($absolute_path){
    $string_position = strpos(ABSPATH, $absolute_path);

    if(0 == $string_position) {
      @mkdir($absolute_path, 0777, true);

      return TRUE;
    }

    return FALSE;
  }

  private function write_in_file($absolute_file_path, $content){
    /** Open file in memory */
    $file_to_update = @fopen($absolute_file_path, "w");

    if($file_to_update){
      @fwrite($file_to_update, $content);
      @fclose($file_to_update);

      return TRUE;
    }

    return FALSE;
  }

  /** Get file / directory permission */
  function get_permission($absolute_file_path){
    /** Check if this function is safe to execute */
    $this->safe_to_execute();

    /** Clears the file status cache */
    clearstatcache();

    /** Return file permission */
    return substr(sprintf('%o', fileperms(ABSPATH.$absolute_file_path)), -4);
  }

  /** Check directory / file is writeable
   *  @return array
   *  --> Status boolean
   *  --> Description */
  function writeable($absolute_file_path){
    /** Check if this function is safe to execute */
    $this->safe_to_execute();

    /** Return true if dir exits */
    if(is_writable(ABSPATH.$absolute_file_path)) return [
      'status' => true,
      'description' => $absolute_file_path.' is writeable'
    ];

    /** Return false if dir does not exits */
    else return [
      'status' => false,
      'description' => $absolute_file_path.' is not writeable'
    ];
  }

  /** Updates File */
  function update_file($absolute_file_path, $content, $create_file = TRUE){
    /** Check application is initialized */
    $this->safe_to_execute();

    /** Create absolute file path */
    $absolute_file_path = ABSPATH.$absolute_file_path;

    /** Check absolute file path and get the response */
    $response = $this->check_path($absolute_file_path);

    /** Check response for valid file */
    if($response['status'] && 'file' == $response['type']){
      if(is_writable($absolute_file_path)){
        $this->write_in_file($absolute_file_path, $content);

        /** File updated successfully => return true */
        return [
          'status' => true,
          'description' => 'File "'.$absolute_file_path.'" has been updated!'
        ];
      }
    }
    
    /** Create new file */
    else if($create_file) {
      $path_components = explode('/', $absolute_file_path);

      $file_name = $path_components[count($path_components) - 1];

      if(!empty($file_name)){
        $new_directory_path = substr($absolute_file_path, 0, strpos($absolute_file_path, $file_name));
        
        if(!file_exists($new_directory_path)) {
          if($this->create_directory($new_directory_path)){
            $this->write_in_file($absolute_file_path, $content);

            /** File updated successfully => return true */
            return [
              'status' => true,
              'description' => 'File "'.$absolute_file_path.'" has been updated!'
            ];
          }
        } else {
          $this->write_in_file($absolute_file_path, $content);

          /** File updated successfully => return true */
          return [
            'status' => true,
            'description' => 'File "'.$absolute_file_path.'" has been updated!'
          ];
        }
      }
    }
    
    /** File not updated => return false */
    return [
      'status' => false,
      'description' => 'Operation Failed! File "'.$absolute_file.'" has not been updated!'
    ];
  }

  /** Copy File */
  function copy_file($source_file, $destination_file){
    $this->safe_to_execute();

    $source = ABSPATH.$source_file;

    $path = explode('/', $destination_file);

    $this->dir_tree = '/';

    for($i = 0; $i < (count($path) -1 ); $i++){
      $this->dir_tree =  $this->dir_tree.$path[$i].'/';
      $temp_dir = ABSPATH.$this->dir_tree;
      if(!is_dir($temp_dir)) @mkdir($temp_dir);
    }

    $destination = ABSPATH.$destination_file;

    if (true === copy($source, $destination)) return [
      'status' => true,
      'description' => 'File successfully backed up at loc: "'.$destination
    ];
    
    
    return [
      'status' => false,
      'description' => 'File "'.$source.'" not copied'
    ];
  }

  /** Delete File */
  function delete_file($absolute_path){
    $this->safe_to_execute();

    $absolute_path = ABSPATH.$absolute_path;

    if(!unlink($absolute_path)) return [
      'status' => true,
      'description' => 'File "'.$absolute_path.'" successfully deleted'
    ];

    return [
      'status' => false,
      'description' => 'Operation Failed!'
    ];
  }

  // Recursive Copy
  function copy_dir($src, $dst){
    $this->safe_to_execute();

    // Open Source Directory
    $dir = opendir($src);

    // Make Directory / Suppress Error
    @mkdir($dst);

    // If destination has no write permission, return
    if(false == $this->writeable($dst)['status']){
      array_push($this->rec_errors, $dst.' is not writable!');
    };

    // Loop directories
    while(false !== ($file = readdir($dir))){
      if(($file != '.') && ($file != '..')){
        if(is_dir($src .'/'.$file)) $this->copy_dir($src.'/'.$file,$dst.'/'.$file); 

        else copy($src . '/' . $file, $dst . '/' . $file);
      } 
    } 
    closedir($dir);

    if(!empty($this->recursive_error)) {
      $errors = $this->rec_errors;

      $this->rec_errors = array();

      return [
        'status' => false,
        'description' => $errors
      ];
    }
    
    return [
      'status' => true,
      'description' => 'Source directory "'.$src.'" successfully copied to "'.$dst.'"'
    ];
  }

  // Recursive Delete
  function delete_dir($dir){
    $this->safe_to_execute();

    // If destination has no write permission, return
    if(false == $this->writeable($dst)['status']){
      array_push($this->rec_errors, $dst.' is not writable!');
    };

    // Remove Directory
    if(is_dir($dir)){
      $files = scandir($dir);

      // Remove the files inside this directory
      foreach ($files as $file)
      if($file != "." && $file != "..") $this->delete_dir("$dir/$file");
    
      // Remove this directory
      rmdir($dir);
    }

    // Remove Individual Files
    else if(file_exists($dir)) unlink($dir);

    if(!empty($this->recursive_error)) {
      $errors = $this->rec_errors;

      $this->rec_errors = array();

      return [
        'status' => false,
        'description' => $errors
      ];
    }
    
    return [
      'status' => true,
      'description' => 'Directory "'.$dir.'" successfully deleted'
    ];
  }

  // Recursively Move Directory
  function move_dir($src, $dst){
    $this->safe_to_execute();

    // If destination has no write permission, return
    if(false == $this->writeable($src)['status']){
      array_push($this->rec_errors, $dst.' is not writable!');
    };

    // If destination has no write permission, return
    if(false == $this->writeable($dst)['status']){
      array_push($this->rec_errors, $dst.' is not writable!');
    };

    // copy directory
    $result = $this->copy_dir($src, $dst);

    if($result['status']) $this->delete_dir($src);
    else {
      array_push($this->rec_errors, 'Copy Failed');
    }

    if(!empty($this->recursive_error)) {
      $errors = $this->rec_errors;

      $this->rec_errors = array();

      return [
        'status' => false,
        'description' => $errors
      ];
    }
    
    return [
      'status' => true,
      'description' => 'Source directory "'.$src.'" successfully moved to "'.$dst.'"'
    ];
  }
}