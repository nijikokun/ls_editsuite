<?php
/*
 * LocalSuite
 * 
 * @author: Nijikokun <nijikokun@gmail.com>
 * @author: iffa
 * @copyright: Copyright (C) 2011
 * @license: GNUv3 Affero License <http://www.gnu.org/licenses/agpl-3.0.html>
 */
 
class Shop_Item {
    private $id = 0;
    private $data = 0;
    private $buy = null;
    private $sell = null;
    private $stock = null;

    function Shop_Item($id, $data) {
        $this->buy = new Price();
        $this->sell = new Price();
        $this->stock = new Stock();
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
        return $this->buy->getPrice();
    }
    
    function getBuyBundle() {
        return $this->buy->getBundle();
    }
    
    function getSell() {
        return $this->sell;
    }
    
    function getSellPrice() {
        return $this->sell->getPrice();
    }
    
    function getSellBundle() {
        return $this->sell->getBundle();
    }
    
    function getBuyCost($amount) {
        return getBuyPrice() * ($amount * getBuyBundle());
    }
    
    function getSellCost($amount) {
        return getSellPrice() * ($amount * getSellBundle());
    }
    
    function getStock() {
        return $this->stock->getCurrent();
    }
    
    function getMaxStock() {
        return $this->stock->getMax();
    }
    
    function setBuy($price, $bundle) {
        $this->buy->setPrice($price);
        $this->buy->setBundle($bundle);
    }
    
    function setSell($price, $bundle) {
        $this->sell->setPrice($price);
        $this->sell->setBundle($bundle);
    }
    
    function setStock($current, $max) {
        $this->stock->setCurrent($current);
        $this->stock->setMax($max);
    }
    
    function toString() {
        return $this->id . ':' . $this->data . '=' . $this->buy->toString() . ',' . $this->sell->toString() . ',' . $this->stock->toString();
    }
}

class Stock {
    private $current = 0;
    private $max = 0;
    
    function Stock($current = 0, $max = 0) {
        $this->current = $current;
        $this->max = $max;
    }
    
    function getCurrent() {
        return $this->current;
    }
    
    function setCurrent($current) {
        $this->current = $current;
    }
    
    function getMax() {
        return $this->max;
    }
    
    function setMax($max) {
        $this->max = $max;
    }
    
    function toString() {
        return $this->current . ':' . $this->max;
    }
}

class Price {
    private $price = 0;
    private $bundle = 0;
    
    function Price($price = 0, $bundle = 0) {
        $this->price = $price;
        $this->bundle = $bundle;
    }
    
    function getPrice() {
        return $this->price;
    }
    
    function setPrice($price) {
        $this->price = $price;
    }
    
    function getBundle() {
        return $this->bundle;
    }
    
    function setBundle($bundle) {
        $this->bundle = $bundle;
    }
    
    function toString() {
        return $this->price . ':' . $this->bundle;
    }
}

