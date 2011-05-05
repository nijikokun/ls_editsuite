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

echo "<h4>Currently Under Construction...</h4>";

$shop = "";
$Shop = new Shop();

$allowed = array(
    'uuid', 'name', 'world', 'creator', 'owner', 'managers', 'locationA', 'locationB', 'money', 'stock',
);

$required = array(
    'uuid', 'shop', 'name', 'world', 'owner', 'locationA', 'locationB',
);

if((isset($_GET['shop']) && $_GET['shop'] != "") || (isset($_POST['shop']) && $_POST['shop'] != "")) {
    $shop = (isset($_POST['shop'])) ? $_POST['shop'] : $_GET['shop'];
    $exists = $Shop->getShop($shop);
    $values = $Shop->readFile()->getValues();
    $itemlist = $Shop->readFile()->getItems();
    if(!$exists) $shop = "";
    if(!$values) $shop = "";
    
    if($shop != "") {
        foreach($values AS $key => $value) {
            $key = str_replace('unlimited-', '', $key);
            
            if(in_array($key, $allowed)) {
                $$key = $value;
            }
        }
        
        if(isset($_POST['submit'])) {
            $shop = new Shop();
            
            foreach($_POST AS $key => $value) {
                if(in_array($key, $allowed)) {
                    $$key = $value;
             
                    if(in_array($key, $required) && $value == '') {
                        $errors[] = "The field <strong>{$key}</strong> is required.";
                    }
                }
            }

            if(count($errors) < 1) { 
                
            }
        }
    }
}
?>
<form method="post" action="<?php echo $_SERVER["PHP_SELF"] ?>">
<?php
if(empty($shop)):
    $shops = $Shop->getShops();
    echo "<label for='shop'>Shop Name:</label><br />";
    echo "<select name='shop'>";
    echo "<option value='' selected>Select a shop</option>";
    
    if(is_array($shops) && count($shops) > 0){
        foreach($shops as $data => $file) {
            echo "<option value='{$data}'>{$data}</option>";
        }
    } else {
        echo "<option value=''>No shops available</option>";
    }
    
    echo "</select> ";
else:
?>
    <input type="hidden" name="shop" id="shop" value="<?php echo $shop; ?>">
    <input type="hidden" name="uuid" id="uuid" value="<?php echo $uuid; ?>">
    
    <div class="col three">
        <label for="world">World:</label> <br /><input type="text" name="world" id="world" value="<?php echo $world; ?>"><br />
        <label for="creator">Creator:</label> <br /><input type="text" name="creator" id="creator" value="<?php echo $creator; ?>">
    </div>
    
    <div class="col three">
        <label for="name">Shop Name:</label> <br /><input type="text" name="name" id="name" value="<?php echo $name; ?>"><br />
        <label for="owner">Owner:</label> <br /><input type="text" name="owner" id="owner" value="<?php echo $owner; ?>"><br />
        <label for="managers">Managers:</label> <br /><input type="text" name="managers" id="managers" value="<?php echo $managers; ?>"><br />
    </div>
    
    <div class="col three">
        <label for="locationA">Position One:</label> <br /><input type="text" name="locationA" id="locationA" value="<?php echo $locationA; ?>"><br />
        <label for="locationB">Position Two:</label> <br /><input type="text" name="locationB" id="locationB" value="<?php echo $locationB; ?>">
    </div>
    
    <div class="clear"></div>
    
    <div class="col three">
        <label for="money">Unlimited Money:</label><br />
        <input type="radio" name="money" value="true"<?=($money == 'true') ? " checked" : "";?>>Yes<br />
        <input type="radio" name="money" value="false"<?=($money != 'true') ? " checked" : "";?>>No
    </div>
    
    <div class="col three">
        <label for="stock">Unlimited Stock:</label><br />
        <input type="radio" name="stock" value="true"<?=($stock == 'true') ? " checked" : "";?>>Yes<br />
        <input type="radio" name="stock" value="false"<?=($stock != 'true') ? " checked" : "";?>>No
    </div>
    
    <div class="clear"></div>
<?php
if(is_array($itemlist) && count($itemlist) > 0){
    foreach($itemlist as $item) {
?>
    <select name="item[]">
        <option value="" selected>Choose an item</option>
<?php foreach($items->getItems() as $data => $name) { $itemName = $item->getId() . ':' . $item->getData(); ?>
        <option value="<?php echo $data; ?>"<?php echo (isset($itemName) && $itemName == $data) ? "selected" : ""; ?>><?php echo $name; ?></option>
<?php } ?>
    </select>
    <input type="text" name="item_buyprice[]" value="<?php echo $item->getBuyPrice(); ?>" size="10" /> <input type="text" name="item_bundlebuy[]" value="<?php echo $item->getBuyBundle(); ?>" size="5" />
    <input type="text" name="item_sellprice[]" value="<?php echo $item->getSellPrice(); ?>" size="10" /> <input type="text" name="item_bundlesell[]" value="<?php echo $item->getSellBundle(); ?>" size="5" />
    <input type="text" name="item_stockcurrent[]" value="<?php echo $item->getStock(); ?>" size="10" /> <input type="text" name="item_stockmax[]" value="<?php echo $item->getMaxStock(); ?>" size="10" />
    <br />
<?php
    }
}
?>

<?php
endif;
?>
    <input type="Submit" value="Edit Shop">
</form>
<?php

include($config['template_path'] . $config['template'] . "/footer.php");
