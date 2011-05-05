<?php
/**
 * FileManager
 * Controls Reading / Writing / Appending / Truncating of files.
 * As well as creating / removing.
 *
 * @author: Nijikokun <nijikokun@gmail.com>
 * @author: iffa
 * @author: Josephos
 * @copyright: Copyright (C) 2011
 * @license: GNUv3 Affero License <http://www.gnu.org/licenses/agpl-3.0.html>
 */
 
class File {
    private $name = "";
    private $lines = "";
    private $source = "";
    
    function File($name = "", $create = false) {
        $this->setFile($name, $create);
    }
    
    function getSource() {
        return $this->source;
    }

    function getLines() {
        return $this->lines;
    }

    function getFileName() {
        return $this->name;
    }

    function setFile($file, $create = false) {
        $this->name = $file;

        if ($create) {
            $this->create();
        }
        
        return $this;
    }
    
    function exists($file = "") {
        return file_exists((empty($file)) ? $this->name : $file);
    }
    
    function writable($file = "") {
        return is_writable((empty($file)) ? $this->name : $file);
    }

    function existsCreate($file = "") {
        $file = (empty($file)) ? $this->name : $file;
        $dirs = "";
        $structure = "";
        
        if (!$this->exists($file)) {
            if(strstr($file, DIRECTORY_SEPARATOR)) {
                $dirs = explode(DIRECTORY_SEPERATOR, $file);
                $dirs = array_pop($dirs);
                if(is_array($dirs) && count($dirs) > 0) $structure = implode(DIRECTORY_SEPERATOR, $dirs);
            }
            
            if(!is_empty($structure)) {
                if (!mkdir($structure, 0755, true)) {
                    return false;
                }
            }
            
            return $this->create($file);
        }
        
        return true;
    }

    function delete($file = "") {
        return unlink((empty($file)) ? $this->name : $file);
    }

    function create($file = "") {
        $file = (empty($file)) ? $this->name : $file;
        
        if(!$this->exists($file)) {
            @chmod($file, 0755);
            $handle = @fopen((empty($file)) ? $this->name : $file, 'w');
            
            if(!$handle) return false;
            
            @fclose($handle);
            
            return true;
        }
        
        return true;
    }
    
    private function getHandle($file = "", $type = 'w') {
        return @fopen((empty($file)) ? $this->name : $file, $type);
    }
    
    private function closeHandle($handle) {
        return @fclose($handle);
    }

    function read($file = "") {
        $file = (empty($file)) ? $this->name : $file;
        if(!$this->exists($file)) return false;
        $this->source = file_get_contents($file);
        $this->lines = explode(PHP_EOL, $this->OSEOL(file_get_contents($file)));
        return true;
    }

    function write($data, $file = "") {
        $file = (empty($file)) ? $this->name : $file;
        if(!$this->exists($file)) return false;
        
        $handle = $this->getHandle($file, 'w');
        if(!$handle) return false;
        
        if(is_array($data) && count($data) > 0) {
            foreach($data as $line) {
                if($line == null || empty($line)) continue;
                
                fwrite($handle, $line . PHP_EOL);
            }
        } elseif (!is_array($data) && strlen($data) > 0) {
            fwrite($handle, $data . PHP_EOL);
        } else {
            $this->closeHandle($handle);
            return false;
        }
        
        $this->closeHandle($handle);
        return true;
    }
    
    function append($data, $file = "") {
        $file = (empty($file)) ? $this->name : $file;
        if(!$this->exists($file)) return false;

        $handle = $this->getHandle($file, 'a');
        if(!$handle) return false;

        if(is_array($data) && count($data) > 0) {
            foreach($data as $line) {
                if($line == null || empty($line)) continue;
                
                fwrite($handle, $line);
            }
        } elseif (!is_array($data) && strlen($data) > 0) {
            fwrite($handle, $data . PHP_EOL);
        } else {
            $this->closeHandle($handle);
            return false;
        }
        
        $this->closeHandle($handle);
        return true;
    }
    
    private function OSEOL($string) {
        return strtr($string, array("\r\n" => PHP_EOL, "\r" => PHP_EOL, "\n" => PHP_EOL)); 
    } 
}

