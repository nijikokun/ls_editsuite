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

$errors = array();
$success = "";

$allowed = array(
    'name', 'world', 'creator', 'owner', 'managers', 'position1', 'position2', 'money', 'stock',
);

$required = array(
    'name', 'world', 'owner', 'position1', 'position2',
);

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
        if($shop->create($world, $name, $owner, $managers, $creator, $position1, $position2, $money, $stock)) {
            $success = "Created shop {$name}, <a href='editor.php?edit={$name}'>edit</a> or <a href='add-item.php?name={$name}'>add items</a>?";
        } else {
            $errors[] = "Could not create shop {$name}!";
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
    echo "<h4>{$success}</h4>";
endif;
?>
<form method="post" action="<?php echo $_SERVER["PHP_SELF"] ?>">
    <div class="col three">
        <label for="world">World:</label> <br /><input type="text" name="world" id="world"><br />
        <label for="creator">Creator (optional):</label> <br /><input type="text" name="creator" id="creator">
    </div>
    
    <div class="col three">
        <label for="name">Shop Name:</label> <br /><input type="text" name="name" id="file"><br />
        <label for="owner">Shop Owner:</label> <br /><input type="text" name="owner" id="owner"><br />
        <label for="managers">Shop Managers (name1, name2):</label> <br /><input type="text" name="managers" id="managers"><br />
    </div>
    
    <div class="col three">
        <label for="position1">Shop Position 1 (x, y, z):</label> <br /><input type="text" name="position1" id="position1"><br />
        <label for="position2">Shop Position 2 (x, y, z):</label> <br /><input type="text" name="position2" id="position2">
    </div>
    
    <div class="clear"></div>
    
    <div class="col three">
        <label for="money">Unlimited Money:</label><br />
        <input type="radio" name="money" value="true">Yes<br />
        <input type="radio" name="money" value="false">No
    </div>
    
    <div class="col three">
        <label for="nostock">Unlimited Stock:</label><br />
        <input type="radio" name="stock" value="true">Yes<br />
        <input type="radio" name="stock" value="false">No
    </div>
    
    <div class="clear"></div>
    
    <input type="Submit" name="submit" value="Generate">
</form>
<?php

include($config['template_path'] . $config['template'] . "/footer.php");