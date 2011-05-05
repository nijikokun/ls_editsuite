<?php
/*
 * LocalSuite
 * 
 * @author: Nijikokun <nijikokun@gmail.com>
 * @author: iffa
 * @copyright: Copyright (C) 2011
 * @license: GNUv3 Affero License <http://www.gnu.org/licenses/agpl-3.0.html>
 */
 
class Item {
	private $id = 0;
	private $data = 0;
	
	private $buy = array(
		'price' => 0,
		'bundle' => 0
	);
	
	private $sell = array(
		'price' => 0,
		'bundle' => 0
	);
	
	private $stock = array(
		'current' => 0,
		'max' => 0
	);

	function Item($id, $data) {
		$this->id = $id;
		$this->data = $data;
	}
	
	function getId() {
		return $this->id;
	}
	
	function getData() {
		return $this->data;
	}
	
	function getBuy() {
		return $this->buy;
	}
	
	function getBuyPrice() {
		return $this->buy['price'];
	}
	
	function getBuyBundle() {
		return $this->buy['bundle'];
	}
	
	function getSell() {
		return $this->sell;
	}
	
	function getSellPrice() {
		return $this->sell['price'];
	}
	
	function getSellBundle() {
		return $this->sell['bundle'];
	}
	
	function getBuyCost($amount) {
		return $this->buy['price'] *($amount * $this->buy['bundle']);
	}
	
	function getSellCost($amount) {
		return $this->sell['price'] *($amount * $this->sell['bundle']);
	}
	
	function getStock() {
		return $this->stock['current'];
	}
	
	function getMaxStock() {
		return $this->stock['max'];
	}
	
	function setBuy($price, $bundle) {
		$this->buy = array(
			'price' => $price,
			'bundle' => $bundle
		);
	}
	
	function setSell($price, $bundle) {
		$this->sell = array(
			'price' => $price,
			'bundle' => $bundle
		);
	}
	
	function setStock($current, $max) {
		$this->stock['current'] = $current;
		$this->stock['max'] = $max;
	}
}

