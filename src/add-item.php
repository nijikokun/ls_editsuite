<?php
/*
 * LocalSuite
 * 
 * @author: Nijikokun <nijikokun@gmail.com>
 * @author: iffa
 * @copyright: Copyright (C) 2011
 * @license: GNUv3 Affero License <http://www.gnu.org/licenses/agpl-3.0.html>
 */

include('inc/init.php');
include($config['template_path'] . $config['template'] . "/header.php");

$Shop = new Shop();
$shop = "";
if(isset($_GET['name'])) $shop = $_GET['name'];

$errors = array();
$success = "";

$allowed = array(
    'shop', 'item', 'buyprice', 'bundlebuy', 'sellprice', 'bundlesell', 'stock',
);

$required = array(
    'shop', 'item',
);

if(isset($_POST['submit'])) {
    foreach($_POST AS $key => $value) {
        if(in_array($key, $allowed)) {
            $$key = $value;
            
            if($common->startsWith($key, 'buy') || $common->startsWith($key, 'sell') || $common->startsWith($key, 'bundle') || $key == 'stock') {
                if($value == "" || $value < 0 || empty($value)) $$key = 0;
            }
     
            if(in_array($key, $required) && empty($value) || $value == "") {
                $errors[] = "The field <strong>{$key}</strong> is required.";
            }
        }
    }
    
    $file = $Shop->getShop($shop);
    
    if($file == false || $file == null) {
        $errors[] = "No shop with the name {$shop} was found.";
    }

    if(count($errors) < 1) { 
        $data = explode(":", $item);
        $item = new Shop_Item($data[0], $data[1]);
        $item->setBuy($buyprice, $bundlebuy);
        $item->setSell($sellprice, $bundlesell);
        $item->setStock(0, $stock);
        
        if($Shop->addItem($item)) {
            $success = "<strong>Added item</strong> ".$items->getName($data[0] . ':' . $data[1])." to <strong>{$shop}</strong> - <a href='editor.php?edit={$shop}'>view changes</a> or add another:<br />";
        } else {
            $errors[] = "Could not add item to {$shop} check to make sure the file is writable!";
        }
    }
}

if(count($errors) > 0):
    echo '<p><strong>There was an error processing the form.</strong></p>';
    echo '<ul>';
    
    foreach($errors as $error):
        echo "<li>$error</li>";
    endforeach;
    
    echo '</ul><br />';
elseif(!empty($success)):
    echo $success;
endif;

?>
<form method="post" action="<?php echo $_SERVER["PHP_SELF"] ?>">
    <div class="col three">
        <label for="shop">Shop Name:</label><br />
        <select name="shop">
            <option value="" selected>Select a shop</option>
<?php 
$shops = $Shop->getShops();
if(is_array($shops) && count($shops) > 0){
    foreach($Shop->getShops() as $data => $file) {
?>
            <option value="<?php echo $data; ?>"<?php echo (isset($shop) && $shop == $data) ? "selected" : ""; ?>><?php echo $data; ?></option>
<?php 
    }
} else {
?>
            <option value="">No shops available</option>
<?php
}
?>
        </select><br />
        <label for="item">Item:</label><br />
    
        <select name="item">
            <option value="" selected>Choose an item</option>
<?php foreach($items->getItems() as $data => $name) { ?>
            <option value="<?php echo $data; ?>"<?php echo (isset($item) && $item == $data) ? "selected" : ""; ?>><?php echo $name; ?></option>
<?php } ?>
        </select>
    </div>
    
    <div class="col three">
        <label for="buyprice">Buy Price:<br /><input type="text" name="buyprice" id="buyprice" value="<?php echo (isset($buyprice)) ? $buyprice : ""; ?>" /><br />
        <label for="bundlebuy">Bundle Size:<br /><input type="text" name="bundlebuy" id="bundlebuy" value="<?php echo (isset($bundlebuy)) ? $bundlebuy : ""; ?>" />
    </div>
    
    <div class="col three">
        <label for="sellprice">Sell Price:<br /><input type="text" name="sellprice" id="sellprice" value="<?php echo (isset($sellprice)) ? $sellprice : ""; ?>" /><br />
        <label for="bundlesell">Bundle Size:<br /><input type="text" name="bundlesell" id="bundlesell" value="<?php echo (isset($bundlesell)) ? $bundlesell : ""; ?>" />
    </div>
    
    <div class="clear"></div>
    
    <div class="col three">
        <label for="stock">Max Stock: <br /><input type="text" name="stock" id="stock" value="<?php echo (isset($stock)) ? $stock : ""; ?>" /><br />
    </div>
    
    <div class="clear"></div>
    
    <input type="Submit" value="Add Item" name="submit" />
</form>
<?php

include($config['template_path'] . $config['template'] . "/footer.php");