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

if(isset($_GET['archive'])) {
    $zip = new ZipArchive();
    $filename = 'Shops_' . date("m-d-Y_h-i-a") . '.zip';
    if ($zip->open($filename, ZIPARCHIVE::CREATE) !== TRUE) {
        die ("Could not open archive");
    }

    $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($config['path']));
    foreach ($iterator as $key => $value) {
        $zip->addFile(realpath($key), $key) or die ("ERROR: Could not add file: $key");
    }
    
    $zip->close();
    $common->download($filename);
    @unlink($filename);
    exit;
}

?>
<h4>Welcome</h4>

You are currently using LocalSuite v<?php echo $config['version']; ?>.<br /><br />
Download all shops as a <a href="?archive">.zip archive</a>?<br /><br />

<h4>Edit a shop file</h4>
<form method="post" action="editor.php">
    <label for="edit">Shop Name:</label> <br />
    <select name="edit">
        <option value="" selected>Select a shop</option>
<?php
$shop = new Shop();
$shop = $shop->getShops();
if(is_array($shop) && count($shop) > 0){
    foreach($shop as $data => $file) {
?>
        <option value="<?php echo $data; ?>"><?php echo $data; ?></option>
<?php 
    }
} else {
?>
        <option value="">No shops available</option>
<?php
}
?>
    </select> 
    <input type="Submit" value="Edit Shop">
</form>
<?php

include($config['template_path'] . $config['template'] . "/footer.php");