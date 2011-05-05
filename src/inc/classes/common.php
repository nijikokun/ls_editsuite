<?php
/*
 * LocalSuite
 * 
 * @author: Nijikokun <nijikokun@gmail.com>
 * @author: iffa
 * @copyright: Copyright (C) 2011
 * @license: GNUv3 Affero License <http://www.gnu.org/licenses/agpl-3.0.html>
 */
 
class Common {
    function startsWith($haystack,$needle,$case=true) {
        if($case){return (strcmp(substr($haystack, 0, strlen($needle)),$needle)===0);}
        return (strcasecmp(substr($haystack, 0, strlen($needle)),$needle)===0);
    }

    function endsWith($haystack,$needle,$case=true) {
        if($case){return (strcmp(substr($haystack, strlen($haystack) - strlen($needle)),$needle)===0);}
        return (strcasecmp(substr($haystack, strlen($haystack) - strlen($needle)),$needle)===0);
    }
    
    function contains($haystack,$needle,$before=false) {
        return strstr($haystack, $needle, $before);
    }
    
    function redirect($url, $permanent = false){
        if($permanent) { header('HTTP/1.1 301 Moved Permanently'); }
        header('Location: '.$url);
        exit();
    }
    
	function download($file) {
		if(ini_get('zlib.output_compression')) {
			ini_set('zlib.output_compression', 'Off');
		}

		// Security checks
		if( $file == "" ) {
			echo "<B>ERROR:</B> The download file was NOT SPECIFIED."; exit;
		} elseif ( ! file_exists( $file ) ) {
			echo "<B>ERROR:</B> File not found."; exit;
		}

		header("Pragma: public");
		header("Expires: 0");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header("Cache-Control: private",false);
		header("Content-Type: application/zip");
		header("Content-Disposition: attachment; filename=".basename($file).";" );
		header("Content-Transfer-Encoding: binary");
		header("Content-Length: ".filesize($file));
        
		readfile($file);
		exit;
	}
    
    function OSEOL($string) {
        return strtr($string, array("\r\n" => PHP_EOL, "\r" => PHP_EOL, "\n" => PHP_EOL)); 
    } 
    
    function name2UUID($name){
        global $config;
        
        if (substr_count($name,'-') == 4 && strlen($name) == 32){
            return $name;
        }
        
        $files = glob($config['path'] . "*.shop");
        $toCheck = strtolower($name);
        if(is_array($files) && count($files) > 0) {
            foreach($files as $file) {
                $lines = explode(PHP_EOL, $this->OSEOL(file_get_contents($file)));
                
                foreach($lines as $line) {
                    $line = trim($line);
                    
                    if($this->startsWith($line, 'name=')) {
                        $data = explode('=', $line);

                        if(strtolower(trim($data[1])) == $toCheck) {
                            return basename($file);
                        } else {
                            continue;
                        }
                    }
                }
            }
        } else {
            return false;
        }
    }
}

