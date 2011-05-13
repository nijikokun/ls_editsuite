<?php
/*
 * LocalSuite
 * 
 * @author: Nijikokun <nijikokun@gmail.com>
 * @author: iffa
 * @copyright: Copyright (C) 2011
 * @license: GNUv3 Affero License <http://www.gnu.org/licenses/agpl-3.0.html>
 */
 
class Shop {
    private $file = "";
    private $manager = null;
    private $uuid = null;
    
    function Shop($file = "") {
        global $FileManager;
        
        $this->manager = $FileManager;
        $this->uuid = new UUID();
        
        if(!empty($file)) {
            $this->manager->setFile($file);
        }
    }
    
    function setFile($file) {
        $this->file = $file;
        $this->manager->setFile($file);
        
        return $this;
    }
    
    function readFile() {
        $this->manager->read();
        
        return $this;
    }
    
    function getLines() {
        return $this->manager->getLines();
    }
    
    function getValues() {
        global $common;
        
        $lines = $this->getLines();
        if($lines == "" && count($lines) < 1) return false;
        
        $items = array();
        foreach($lines as $line) {
            if($common->contains($line, ":")) continue;
            if(!$common->contains($line, "=")) continue;
            $line = str_replace("\\:", ":", $line);
            $data = explode("=", $line, 2);
			$items[$data[0]] = $data[1];
        }
        
        return $items;
    }
    
    function getValue($key) {
        global $common;
        
        $values = $this->getValues();
        if($values == "" && count($values) < 1) return false;
        
        foreach($values as $k => $value) {
            if(strtolower($key) == strtolower($k)) return $value;
        }
        
        return false;
    }
    
    function getItems() {
        global $common;
        
        $lines = $this->getLines();
        if($lines == "" && count($lines) < 1) return "";
        
        $items = array();
        foreach($lines as $line) {
            if(!$common->contains($line, ":")) continue;
            if(!$common->contains($line, "=")) continue;
            $i = 1;
            $line = str_replace("\\:", ":", $line);
            $data = explode("=", $line, 2);
			$item_data = explode(":", $data[0]);
            
            // Create the item
			$item = new Shop_Item($item_data[0], $item_data[1]);
			
			$item_values = explode(",", $data[1]);
			foreach($item_values as $line_item) {
				$value = explode(":", $line_item);
				
				switch($i) {
					case 1: $item->setBuy($value[0], $value[1]); break;
					case 2: $item->setSell($value[0], $value[1]); break;
					case 3: $item->setStock($value[0], $value[1]); break;
				}
				
				$i++;
			}
			
			$items[] = $item;
        }
        
        return $items;
    }
    
    function create($world, $name, $owner, $managers, $creator, $pos1, $pos2, $money, $stock) {
        global $config;
        
        $uuid = $this->uuid->v4();
        $this->manager->setFile($config['path'] . $uuid . ".shop", true);
        
        if(!$this->manager->writable()) {
            $this->manager->delete();
            $this->manager->create();
        }
        
        if(!$this->manager->writable()) return false;
        
        $data = array(
            '# LocalShops Config Version 2.0, built by LocalSuite',
            '# $id' . time() . '$',
            'uuid=' . $uuid,
            'world=' . $world,
            'name=' . $name,
            'owner=' . $owner,
            'managers=' . $managers,
            'creator=' . $creator,
            'locationA=' . $pos1,
            'locationB=' . $pos2,
            'unlimited-money=' . $money,
            'unlimited-stock=' . $stock
        );

        return $this->manager->write($data);
    }
    
    function update($data) {
        return $this->manager->write($data);
    }
    
    function addItem($item) {
        return $this->manager->append($this->parseItem($item));
    }
    
    function parseMapping($key, $value) {
        $line = $key . "=" . $value;
        return $this->parseLine($line);
    }
    
    function parseItem($item) {
        $item = $item->toString();
        return $this->parseLine($item);
    }
    
    function parseLine($line) {
        $line = $item = str_replace(':', '\:', $line);
        return $line;
    }
    
    function getShops() {
        global $config, $common;
        
        $files = glob($config['path'] . "*.shop");
        $names = array();
        if(is_array($files) && count($files) > 0) {
            foreach($files as $file) {
                $lines = explode(PHP_EOL, $common->OSEOL(file_get_contents($file)));
                
                foreach($lines as $line) {
                    $line = trim($line);
                    
                    if($common->startsWith($line, 'name=')) {
                        $data = explode('=', $line);
                        $names[trim($data[1])] = basename($file);
                    }
                }
            }
        } else {
            return false;
        }
        
        return $names;
    }
    
    function getShop($name) {
        global $config;
        
        $toCheck = strtolower($name);
        $shops = $this->getShops();
        
        if(!is_array($shops) && count($shops) < 1) return null;
        
        foreach($shops as $shop => $filename) {
            if(strtolower($shop) == $toCheck){ $this->setFile($config['path'] . $filename); return $this->file; }
            continue;
        }
    }
}

class UUID {
  public static function v3($namespace, $name) {
    if(!self::is_valid($namespace)) return false;

    // Get hexadecimal components of namespace
    $nhex = str_replace(array('-','{','}'), '', $namespace);

    // Binary Value
    $nstr = '';

    // Convert Namespace UUID to bits
    for($i = 0; $i < strlen($nhex); $i+=2) {
      $nstr .= chr(hexdec($nhex[$i].$nhex[$i+1]));
    }

    // Calculate hash value
    $hash = md5($nstr . $name);

    return sprintf('%08s-%04s-%04x-%04x-%12s',

      // 32 bits for "time_low"
      substr($hash, 0, 8),

      // 16 bits for "time_mid"
      substr($hash, 8, 4),

      // 16 bits for "time_hi_and_version",
      // four most significant bits holds version number 3
      (hexdec(substr($hash, 12, 4)) & 0x0fff) | 0x3000,

      // 16 bits, 8 bits for "clk_seq_hi_res",
      // 8 bits for "clk_seq_low",
      // two most significant bits holds zero and one for variant DCE1.1
      (hexdec(substr($hash, 16, 4)) & 0x3fff) | 0x8000,

      // 48 bits for "node"
      substr($hash, 20, 12)
    );
  }

  public static function v4() {
    return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',

      // 32 bits for "time_low"
      mt_rand(0, 0xffff), mt_rand(0, 0xffff),

      // 16 bits for "time_mid"
      mt_rand(0, 0xffff),

      // 16 bits for "time_hi_and_version",
      // four most significant bits holds version number 4
      mt_rand(0, 0x0fff) | 0x4000,

      // 16 bits, 8 bits for "clk_seq_hi_res",
      // 8 bits for "clk_seq_low",
      // two most significant bits holds zero and one for variant DCE1.1
      mt_rand(0, 0x3fff) | 0x8000,

      // 48 bits for "node"
      mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
    );
  }

  public static function v5($namespace, $name) {
    if(!self::is_valid($namespace)) return false;

    // Get hexadecimal components of namespace
    $nhex = str_replace(array('-','{','}'), '', $namespace);

    // Binary Value
    $nstr = '';

    // Convert Namespace UUID to bits
    for($i = 0; $i < strlen($nhex); $i+=2) {
      $nstr .= chr(hexdec($nhex[$i].$nhex[$i+1]));
    }

    // Calculate hash value
    $hash = sha1($nstr . $name);

    return sprintf('%08s-%04s-%04x-%04x-%12s',

      // 32 bits for "time_low"
      substr($hash, 0, 8),

      // 16 bits for "time_mid"
      substr($hash, 8, 4),

      // 16 bits for "time_hi_and_version",
      // four most significant bits holds version number 5
      (hexdec(substr($hash, 12, 4)) & 0x0fff) | 0x5000,

      // 16 bits, 8 bits for "clk_seq_hi_res",
      // 8 bits for "clk_seq_low",
      // two most significant bits holds zero and one for variant DCE1.1
      (hexdec(substr($hash, 16, 4)) & 0x3fff) | 0x8000,

      // 48 bits for "node"
      substr($hash, 20, 12)
    );
  }

  public static function is_valid($uuid) {
    return preg_match('/^\{?[0-9a-f]{8}\-?[0-9a-f]{4}\-?[0-9a-f]{4}\-?'.
                      '[0-9a-f]{4}\-?[0-9a-f]{12}\}?$/i', $uuid) === 1;
  }
}