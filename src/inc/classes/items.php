<?php
/*
 * LocalSuite
 * 
 * @author: Nijikokun <nijikokun@gmail.com>
 * @author: iffa
 * @copyright: Copyright (C) 2011
 * @license: GNUv3 Affero License <http://www.gnu.org/licenses/agpl-3.0.html>
 */
 
class Items {
	private $items = array();

	function Items($file) {
		$data = explode("\n", file_get_contents($file));
		
		foreach($data as $line) {
			$item = explode(' ', $line, 2);

			if(strstr($item[0], ':')) {
				$item_value = $item[0];
			} else {
				$item_value = $item[0] . ':0';
			}
			
			$this->items[$item_value] = trim($item[1]);
		}
	}
	
	function getName($id) {
		return $this->items[$id];
	}
    
    function getItems() {
        return $this->items;
    }
}

